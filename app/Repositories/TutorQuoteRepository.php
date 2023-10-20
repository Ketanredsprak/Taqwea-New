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
            if ($check_quote_submit == 0) {
                $result = $this->create($post);
                DB::commit();
                return $result;
            } else {
                return false;
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /**
     * Function updateFaq
     *
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function tutorRequestUpdate($post, $id)
    {
        // try {
        //     DB::beginTransaction();
        //     $result = $this->update($post, $id);
        //     DB::commit();
        //     return $result;
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     throw ($e);
        // }
    }

    /**
     * Get details of TutorRequest
     *
     * @param array $where
     *
     * @return Collection
     */
    public function getTutorRequestDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }

    /**
     * Get  TutorRequests  all
     *
     * @param array $where
     *
     * @return Collection
     */
    public function getTutorRequests(array $params = [])
    {

        $limit = 10;
        $query = $this;

        if (!empty($params['search'])) {
            $query->whereTranslationLike('question', "%" . $params['search'] . "%");
        }

        return $query->paginate($limit);

    }

    /**
     * Method deleteTutorRequest
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteTutorRequest(int $id): int
    {
        return $this->delete($id);
    }

    /**
     * Method cancelClassRequest
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function cancelClassRequest($id)
    {
        try {
            DB::beginTransaction();
            $datas = $this->where('class_request_id', $id)->get();
            foreach ($datas as $data) {
                    $updateclassquotestatus = ClassQuotes::find($data->id);
                    $updateclassquotestatus->status = 4;
                    $updateclassquotestatus->update();
                    }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }

    }


    /**
     * Method getTutorListWithQuote
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function getTutorListWithQuote($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->where('class_request_id', $id)->where('status',0)->paginate('10');
            return $result;
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }

    }


}
