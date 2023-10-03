<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container as Application;

use App\Models\User;
use App\Models\TransactionItem;
use App\Repositories\CartItemRepository;
use App\Services\SubscriptionService;
use Exception;

class BlogRepository extends BaseRepository
{
    protected $walletRepository;

    protected $tutorSubscriptionRepository;

    protected $subscriptionService;

    protected $tutorRepository;

    /**
     * Method __construct
     *
     * @param Application        $app
     * @param CartItemRepository $cartItemRepository
     *
     * @return void
     */
    public function __construct(
        Application $app,
        CartItemRepository $cartItemRepository,
        SubscriptionService $subscriptionService,
        TutorRepository $tutorRepository
    ) {
        parent::__construct($app);
        $this->cartItemRepository = $cartItemRepository;
        $this->subscriptionService = $subscriptionService;
        $this->tutorRepository = $tutorRepository;
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Blog::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Method getBlogs
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getBlogs(array $params = [])
    {
        $sortFields = [
            'id' => 'blogs.id',
            'blog_title' => 'blog_title',
            'created_at' => 'created_at',
            'tutor_name' => 'user_translations.name',
            'category'   => 'category_translations.name',
            'subject'  => 'subject_translations.subject_name',
            'type'  => 'type',
            'created_at' => 'blogs.created_at',
            'total_fees' => 'blogs.total_fees',
            'status' => 'status',
        ];

        $language = getUserLanguage($params);

        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select("blogs.*")->withTranslation()
            ->leftjoin(
                'user_translations',
                'user_translations.user_id',
                'blogs.tutor_id'
            )
            ->leftjoin(
                'category_translations',
                'category_translations.category_id',
                'blogs.category_id'
            )->leftjoin(
                'subject_translations',
                'subject_translations.subject_id',
                'blogs.subject_id'
            );

        if ($language && Auth::check() && Auth::user()->user_type === User::TYPE_ADMIN) {
            $query->whereRaw(
                "if(category_translations.language IS NOT NULL,
                category_translations.language= '" . $language . "',
                true )"
            );
            $query->whereRaw(
                "if(subject_translations.language IS NOT NULL,
                subject_translations.language= '" . $language . "',
                true )"
            );
            $query->whereRaw(
                "if(user_translations.language IS NOT NULL,
                user_translations.language= '" . $language . "',
                true )"
            );
        }

        if ($loggedInUser) {
            $dbRaw =  DB::raw(
                "(SELECT count(*)
                    FROM transaction_items
                    WHERE transaction_items.blog_id = blogs.id
                    AND student_id = " . $loggedInUser->id . "
                )
                    as blog_purchased_count
                "
            );
            $query->addSelect($dbRaw);
        }

        if ($loggedInUser && !$loggedInUser->isAdmin()) {
            if ($loggedInUser->isTutor()) {
                $query->where('tutor_id', $loggedInUser->id);
            }
            $query->withCount(
                [
                    'cartItem' =>
                    function ($q) use ($loggedInUser) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($loggedInUser) {
                                $subQuery->where('user_id', $loggedInUser->id);
                            }
                        );
                    }
                ]
            );

            if ($loggedInUser->isStudent()) {
                $query->whereNotIn(
                    'blogs.id',
                    function ($query) use ($loggedInUser) {
                        $query->select('blog_id')
                            ->from('transaction_items')
                            ->where('student_id', $loggedInUser->id)
                            ->where("status", TransactionItem::STATUS_CONFIRMED)
                            ->whereNotNull('blog_id');
                    }
                );
            }
        }

        if (@$params['tutor_id']) {
            $query->where('blogs.tutor_id', $params['tutor_id']);
        }

        if ((@$params['min_price'] >= 0) && @$params['max_price']) {
            $query->whereBetween(
                'blogs.total_fees',
                [
                    $params['min_price'],
                    $params['max_price']
                ]
            );
        } else if (isset($params['min_price']) && @$params['min_price'] >= 0) {
            $query->where('blogs.total_fees', '>', $params['min_price']);
        }
        if (@$params['category']) {
            if (!is_array($params['category'])) {
                $params['category'] = [$params['category']];
            }
            $query->whereIn('blogs.category_id', $params['category']);
        }

        if (@$params['level']) {
            $query->where(
                function ($q) use ($params) {
                    $q->whereIn('blogs.level_id', $params['level']);
                    if (@$params['gk_level']) {
                        $q->orWhereIn('blogs.level_id', $params['gk_level']);
                    }
                    if (@$params['language_level']) {
                        $q->orWhereIn('blogs.level_id', $params['language_level']);
                    }
                }
            );
        } else {
            if (@$params['gk_level']) {
                $query->whereIn('blogs.level_id', $params['gk_level']);
            }

            if (@$params['language_level']) {
                $query->whereIn('blogs.level_id', $params['language_level']);
            }
        }

        if (@$params['grade']) {
            $query->whereIn('blogs.grade_id', $params['grade']);
        }

        if (@$params['subject']) {
            $query->whereIn('blogs.subject_id', $params['subject']);
        }

        if (!empty($params['from_date'])) {
            $query->whereDate('blogs.created_at', '>=', $params['from_date']);
        }

        if (!empty($params['to_date'])) {
            $query->whereDate('blogs.created_at', '<=', $params['to_date']);
        }

        if (!empty($params['status'])) {
            $query->where('blogs.status', $params['status']);
        }

        if (!empty($params['content_type'])) {
            $query->where('blogs.type', $params['content_type']);
        }

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->whereTranslationLike(
                        'blog_title',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'user_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'category_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'subject_translations.subject_name',
                        'like',
                        "%" . $params['search'] . "%"
                    );
                }
            );
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        if (in_array($sort, ['blog_title'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $query->groupBy("blogs.id");
        if (isset($params['is_paginate'])) {
            return $query->get();
        }
        return $query->paginate($size);
    }

    /**
     * Method getBlog
     *
     * @param int $id [explicite description]
     *
     * @return Blog
     */
    public function getBlog(int $id)
    {
        return $this->find($id);
    }

    /**
     * Method getBlog
     *
     * @param string $slug [explicite description]
     * @param int    $id
     *
     * @return Blog
     */
    public function getBlogBySlug(
        string $slug = '',
        $id = '',
        bool $withTrashed = true
    ) {
        if ($id) {
            $query = $this->where('id', $id);
        } else {
            $query = $this->where('slug', $slug);
        }
        if (Auth::check() & $withTrashed) {
            $user = Auth::user();
            $query->withCount(
                [
                    'cartItem' =>
                    function ($q) use ($user) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($user) {
                                $subQuery->where('user_id', $user->id);
                            }
                        );
                    }
                ]
            );
            $query->with(
                [
                    'cartItem' =>
                    function ($q) use ($user) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($user) {
                                $subQuery->where('user_id', $user->id);
                            }
                        );
                    }
                ]
            );
        }
        if ($withTrashed) {
            $query->withTrashed();
        }
        return $query->first();
    }

    /**
     * Method createBlog
     *
     * @param array $data [explicite description]
     *
     * @return Blog
     */
    public function createBlog(array $data): Blog
    {
        try {
            DB::beginTransaction();
            $this->checkBlogCreation();

            if (!empty($data['media'])) {
                $data['media'] = uploadFile(
                    $data['media'],
                    'blogs',
                    'private',
                    [
                        'width' => 300,
                        'height' => 150
                    ]
                );
                $fileType = getFileTypeFromMime($data['mimeType']);
                $data['type'] = $this->_getBlogType($fileType);
            }

            $blog = $this->create($data);
            DB::commit();
            return $blog;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Method updateBlog
     *
     * @param array $data [explicite description]
     * @param int   $id
     *
     * @return Blog
     */
    public function updateBlog(array $data, $id): Blog
    {
        $blog = $this->getBlog($id);
        if (!empty($data['media'])) {
            $data['media'] = uploadFile(
                $data['media'],
                'blogs',
                'public',
                [
                    'width' => 300,
                    'height' => 150
                ]
            );
            deleteFile($blog->media);
            $data['type'] = getFileTypeFromMime($data['mimeType']);
        }

        return $this->update($data, $blog->id);
    }

    /**
     * Method deleteBlog
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteBlog(int $id): int
    {
        $this->cartItemRepository->deleteBlogItem($id);
        return $this->delete($id);
    }

    /**
     * Get blog max price
     *
     * @return Blog
     */
    public function getMaxPrice()
    {
        return $this->max('total_fees');
    }

    /**
     * Method getBlogType
     *
     * @param string $fileType [explicite description]
     *
     * @return string
     */
    private function _getBlogType(string $fileType): string
    {
        $blogType = Blog::TYPE_DOCUMENT;
        if ($fileType == Blog::TYPE_IMAGE) {
            $blogType = Blog::TYPE_IMAGE;
        } elseif ($fileType == Blog::TYPE_VIDEO) {
            $blogType = Blog::TYPE_VIDEO;
        }

        return $blogType;
    }

    /**
     * Method checkBlogCreation
     *
     * @return void
     */
    public function checkBlogCreation()
    {
        $user = Auth::user();
        $this->subscriptionService
            ->checkCreation(Blog::BLOG_TYPE);

        $tutor = $this->tutorRepository->getTutor($user->id);
        $this->tutorRepository->updateTutor($user, ["blog" => ($tutor->blog) - 1]);
    }

    /**
     * Method getDashboardCount
     *
     * @param array $params
     *
     * @return mixed
     */
    public function getDashboardCount(
        array $params = []
    ) {
        $where = "";
        if (!empty($params['tutor_id'])) {
            $where .= " AND tutor_id = " . $params['tutor_id'];
        }
        return $this->select(
            DB::raw(
                "(SELECT COUNT(id)
                    FROM blogs
                    WHERE status = '" . Blog::ACTIVE . "'
                    $where
                ) AS total_blogs"
            )
        )->first();
    }

    /**
     * Method deleteUsersBlog
     *
     * @param int $tutorId [explicite description]
     *
     * @return bool
     */
    public function deleteUsersBlog(int $tutorId): int
    {
        $blogLists = $this->where('tutor_id', $tutorId)->get();
        foreach ($blogLists as $blog) {
            $this->deleteBlog($blog->id);
        }
        return true;
    }

}
