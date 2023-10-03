<?php
namespace App\Repositories;

use App\Models\CategoryGrade;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryGradeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return CategoryGrade::class;
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
     * Method getGrades
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getGrades($params)
    {
        $query = $this->with('grade');
        $query->select('category_grades.*');
        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM class_webinars
                WHERE (category_grades.grade_id = class_webinars.grade_id
                OR category_grades.grade_id = class_webinars.level_id)
                and class_type = 'class'
                and status = 'active'
            ) as class_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM class_webinars
                WHERE (category_grades.grade_id = class_webinars.grade_id
                OR category_grades.grade_id = class_webinars.level_id)
                and class_type = 'webinar'
                and status = 'active'
            ) as webinar_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM user_grades
                LEFT join tutors 
                ON user_grades.user_id = tutors.user_id
                WHERE category_grades.grade_id = user_grades.grade_id
                AND tutors.is_featured = 1
            ) as tutor_count"
        );
        $query->addSelect($dbRaw);

        $dbRaw =  DB::raw(
            "(SELECT count(*) 
                FROM category_subjects
            WHERE category_grades.grade_id = category_subjects.grade_id
            ) as subject_count"
        );
        $query->addSelect($dbRaw);

        $categories = [];
        if (!empty($params['category_id'])) {
            $categories = $params['category_id'];
            if (!is_array($categories)) {
                $categories = explode(',', $categories);
            } 

            $query->whereIn('category_id', $categories);
        }

        $query->groupBy('grade_id');
        return $query->get();
    }
}