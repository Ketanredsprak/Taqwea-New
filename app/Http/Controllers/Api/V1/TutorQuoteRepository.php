<?php

namespace App\Repositories;

use App\Models\ClassQuotes;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Interface Repository.
 *
 * @package TutorQuoteRepository;
 */
class TutorQuoteRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassQuotes::class;
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
     * Function getdemo
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function getTutorRequest($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Function createTutorRequest
     *
     * @param $post [explicite description]
     *
     * @return void
     */
    public function createTutorRequest($post)
    {

        try {
            DB::beginTransaction();

            $check_quote_submit = $this->where('class_request_id', $post['class_request_id'])->where('tutor_id', $post['tutor_id'])->count();
            if ($check_quote_submit == 