<?php
namespace App\Repositories;

use App\Models\CategorySubject;
use App\Models\ClassWebinar;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class CategorySubjectRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return CategorySubject::class;
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
     * Method getSubjects
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getSubjects($params = [])
    {
        $language = config('app.locale');
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select(
            'category_subjects.id',
            'category_subjects.category_id as category_id',
            'category_translations.name as category_name',
            'grade_translations.grade_name',
            DB::raw(
                'group_concat(
                    subject_translations.subject_name SEPARATOR", "
                ) as subjects'
            )
        )
            ->leftjoin(
                'category_translations',
                'category_translations.category_id',
                'category_subjects.category_id'
            )
            ->leftjoin(
                'grade_translations',
                'grade_translations.grade_id',
                'category_subjects.grade_id'
            )
            ->leftjoin(
                'subject_translations',
                'subject_translations.subject_id',
                'category_subjects.subject_id'
            )
            ->where('category_translations.language', $language)
            ->whereRaw(
                "IF(
                    category_subjects.grade_id IS NOT NULL,
                    grade_translations.language = '$language',
                    true
                )"
            )
            ->where('subject_translations.language', $language)
            ->groupBy(
                [
                    'category_subjects.category_id',
                    'category_subjects.grade_id'
                ]
            );

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->where(
                        'category_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'grade_translations.grade_name',
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

        return $query->paginate($size);
    }
    
    /**
     * Method addSubjects
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function addSubjects(array $data)
    {
        $grade = $data['grade_id'] ?? null;
        $categorySubject = $this->where('category_id', $data['category_id'])
            ->where('grade_id', $grade)
            ->first();
        if ($categorySubject) {
            throw new Exception('Subject is already added for this combination.');
        }

        foreach ($data['subject_id'] as $subject) {
            $insertData = [
                'category_id' => $data['category_id'],
                'grade_id' => $grade,
                'subject_id' => $subject,
            ];

            $this->create($insertData);
        } 
    }
    
    /**
     * Method deleteSubjects
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteSubjects(int $id):int
    {
        $subject = $this->where('id', $id)->first();

        if (!$subject) {
            throw new ModelNotFoundException(
                trans('error.model_not_found')
            );
        }

        return $this->where('category_id', $subject->category_id)
            ->where('grade_id', $subject->grade_id)
            ->delete();
    }

    /**
     * Method getSubjects
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getUniqueSubjects($params = [], $paginate = true)
    {
        $language = config('app.locale');
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select(
            'category_subjects.subject_id',
            'subject_translations.subject_name',
            
        )
            ->leftjoin(
                'subject_translations',
                'subject_translations.subject_id',
                'category_subjects.subject_id'
            )
          
            
            ->where('subject_translations.language', $language)
            ->groupBy(
                [
                    'category_subjects.subject_id'
                ]
            );

        if (!empty($params['category_id'])) {
            $categories = $params['category_id'];
            if (!is_array($categories)) {
                $categories = explode(',', $categories);
            } 
            
            $query->whereIn('category_id', $categories);
        }

        if (!empty($params['grade_id'])) {
            $grades = $params['grade_id'];
            if (!is_array($grades)) {
                $grades = explode(',', $grades);
            } 

            $query->whereIn('grade_id', $grades);
        }
        if (!empty($params['count'])) {
            $dbRaw =  DB::raw(
                "(SELECT count(*) 
                    FROM class_webinars
                    WHERE category_subjects.subject_id = class_webinars.subject_id
                    and category_subjects.category_id = class_webinars.level_id
                    and class_type = '" . ClassWebinar::TYPE_CLASS . "'
                    and status = '" . ClassWebinar::STATUS_ACTIVE . "'
                )
                    as class_count
                "
            );
            $query->addSelect($dbRaw);

            $dbRaw =  DB::raw(
                "(SELECT count(*) 
                    FROM class_webinars
                    WHERE category_subjects.subject_id = class_webinars.subject_id
                    and category_subjects.category_id = class_webinars.level_id
                    and class_type = '" . ClassWebinar::TYPE_WEBINAR. "'
                    and status = '" . ClassWebinar::STATUS_ACTIVE . "'
                )
                    as webinar_count
                "
            );
            $query->addSelect($dbRaw);

            $dbRaw =  DB::raw(
                "(SELECT count(*) 
                    FROM user_subjects
                    LEFT join tutors 
                    ON user_subjects.user_id = tutors.user_id
                    WHERE category_subjects.subject_id = user_subjects.subject_id
                    AND tutors.is_featured = 1
                )
                    as tutor_count
                "
            );

            $query->addSelect($dbRaw);
        }
        if ($paginate) {
            return $query->paginate($size);
        } else {
            return $query->get();
        }
    }

    /**
     * Method getById
     * 
     * @param int $id 
     * 
     * @return Object
     */
    public function getById($id)
    {
        $categorySubject = $this->find($id);
        $language = config('app.locale');
        
        $query = $this->select(
            'category_subjects.id',
            'category_subjects.category_id as category_id',
            'category_subjects.grade_id',
            'category_translations.name as category_name',
            'grade_translations.grade_name',
            DB::raw(
                'group_concat(category_subjects.subject_id) as subjects_id'
            )
        )
            ->leftjoin(
                'category_translations',
                'category_translations.category_id',
                'category_subjects.category_id'
            )
            ->leftjoin(
                'grade_translations',
                'grade_translations.grade_id',
                'category_subjects.grade_id'
            )
            ->leftjoin(
                'subject_translations',
                'subject_translations.subject_id',
                'category_subjects.subject_id'
            )
            ->where('category_subjects.category_id', $categorySubject->category_id)
            ->where('category_subjects.grade_id', $categorySubject->grade_id)
            ->where('category_translations.language', $language)
            ->whereRaw(
                "IF (category_subjects.grade_id,
                grade_translations.language='".$language."',true)"
            );
            return $query->first();
    }
}
