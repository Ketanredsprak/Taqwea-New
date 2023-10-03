<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\CmsPage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Interface Repository.
 *
 * @package CmsRepository;
 */
class CmsRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsPage::class;
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
     * Function getCms
     * 
     * @param int $id [explicite description]
     * 
     * @return void
     */
    public function getCms($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Function updateFaq
     * 
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function cmsUpdate($post, $id)
    {
        try {
            DB::beginTransaction();
            $result = $this->update($post, $id);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /** 
     * Get details of cms
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getCmsDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }
}
