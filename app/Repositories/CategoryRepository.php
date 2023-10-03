<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\ClassWebinar;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Category::class;
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
     * Method getCategories
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getCategories(array $params = [])
    {

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->withTranslation();
        $query->select('categories.*');
        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM class_webinars
                WHERE (categories.id = class_webinars.category_id
                OR categories.id = class_webinars.level_id)
                and class_type = '" . ClassWebinar::TYPE_CLASS . "'
                and status = '" . ClassWebinar::STATUS_ACTIVE . "'
            ) as class_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM class_webinars
                WHERE (categories.id = class_webinars.category_id
                OR categories.id = class_webinars.level_id)
                and class_type = '" . ClassWebinar::TYPE_WEBINAR . "'
                and status = '" . ClassWebinar::STATUS_ACTIVE . "'
            ) as webinar_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM category_subjects
            WHERE categories.id = category_subjects.category_id
            ) as subject_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM user_levels
                LEFT join tutors 
                ON user_levels.user_id = tutors.user_id
            WHERE categories.id = user_levels.category_id
                AND tutors.is_featured = 1
            ) as tutor_count"
        );
        $query->addSelect($dbRaw);

        if (!empty($params['all'])) {
            $query->whereRaw(
                "if(handle IS NOT NULL,
                handle != 'education',
                true )"
            );

            $query->whereRaw(
                "if(parent_id IS NOT NULL,
                parent_id in(select id from categories where handle = 'education'),
                true )"
            );
        } else {

            if (!empty($params['parent_id'])) {
                $query->where('parent_id', $params['parent_id']);
            } else {
                $query->where('parent_id', null);
            }
        }

        if (!empty($params['search'])) {
            $query->whereTranslationLike('name', "%" . $params['search'] . "%");
        }

        return $query->paginate($size);
    }

    /**
     * Method getByHandle
     *
     * @param string $handle [explicite description]
     *
     * @return Category
     */
    public function getByHandle(string $handle): Category
    {
        return $this->where('handle', $handle)->first();
    }

    /**
     * Method getCategory
     *
     * @param int $id [explicite description]
     *
     * @return Category
     */
    public function getCategory(int $id): Category
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method getParentCategories
     *
     * @return Collection
     */
    public function getParentCategories()
    {
       
            return $this->withTranslation()
            ->where('parent_id', null)
            ->paginate();
    }

    /**
     * Method getLevels
     *
     * @param array $data [explicite description]
     *
     * @return Collection
     */
    public function getLevels(array $data = [])
    {
        $educattion = $this->getByHandle(Category::HANDLE_EDUCATION);
        return $this->withTranslation()
            ->where('parent_id', $educattion->id)
            ->get();
    }

    /**
     * Method addCategory
     *
     * @param array $data [explicite description]
     *
     * @return Category
     */
    public function addCategory(array $data): Category
    {
        if (!empty($data['icon'])) {
            $data['icon'] = uploadFile(
                $data['icon'],
                'icon'
            );
        }
        return $this->create($data);
    }

    /**
     * Method addCategory
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return Category
     */
    public function updateCategory(array $data, int $id): Category
    {
       
        $category_data = $this->getCategory($id);
        if (!empty($data['icon'])) {
            $data['icon'] = uploadFile(
                $data['icon'],
                'icon'
            );
            deleteFile($category_data->icon);
        } else {
            unset($data['icon']);
        }
        return $this->update($data, $id);
    }

    /**
     * Method deleteCategory
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteCategory(int $id): int
    {
        return $this->delete($id);
    }
}
