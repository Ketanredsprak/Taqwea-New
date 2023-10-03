<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SubjectRepository extends BaseRepository
{

    /**
     * Method __construct
     *
     * @param Application                    $app
     * @return void
     */
    public function __construct(
        Application $app
    ) {
        parent::__construct($app);

    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Subject::class;
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
     * @return void
     */
    public function getSubjects(array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'subject_name' => 'subject_name'
        ];

        $limit = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->withTranslation();

        if (!empty($params['search'])) {
            $query->whereTranslationLike('subject_name', "%".$params['search']."%");
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }
        
        if (in_array($sort, ['subject_name'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }
        if (!empty($params["without_paginate"])) {
            return $query->get();
        }
        return $query->paginate($limit);
    }

    /**
     * Function getSubject
     * 
     * @param $id 
     * 
     * @return void
     */
    public function getSubject(int $id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method addSubject
     *
     * @param array $data [explicite description]
     *
     * 
     * 
     * @return Subject
     */
    public function addSubject(array $data): Subject
    {

        // dd($data);

        if (!empty($data['subject_icon'])) {
                    $data['subject_icon'] = uploadFile(
                        $data['subject_icon'],
                        'subject_icon'
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
     * @return Subject
     */
    public function updateSubject(array $data, int $id): Subject
    {
        $subject_data = $this->getSubject($id);
            if (!empty($data['subject_icon'])) {
                $data['subject_icon'] = uploadFile(
                    $data['subject_icon'],
                    'subject_icon'
                );
                deleteFile($subject_data->subject_icon);
            } else {
                unset($data['subject_icon']);
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
    public function deleteSubject(int $id): int
    {
        return $this->delete($id);
    }

    /**
     * Get all subjects
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getAll(array $params = [])
    {
        return $this->withTranslation()->where($params)->get();
    }
}
