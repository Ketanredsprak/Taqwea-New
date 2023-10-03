<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Bank;
use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Interface Repository.
 *
 * @package CmsRepository;
 */
class BankRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bank::class;
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
     * Function Create Bank Details
     * 
     * @param array $data 
     * 
     * @return void 
     */
    public function createBankDetails(array $data)
    {
        return $this->create($data);
    }

    /**
     * Function Create Bank Details
     * 
     * @param array $data 
     * 
     * @return void 
     */
    public function updateBankDetails(array $data, $id)
    {
        return $this->update($data, $id);
    }

    
    /**
     * Function getAll
     * 
     * @return void 
     */
    public function getAll()
    {
        return $this->withTranslation()->get();
    }


    /**
     * Function getAll
     * 
     * @param int $id 
     * 
     * @return void 
     */
    public function getById(int $id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Function ListSupportRequest
     *
     * @param array $data    
     * 
     * @return Collection
     */
    public function getAllBanks(array $data)
    {
        $columns = ['id', 'bank_name', 'bank_code'];
        $query = $this->select(
            '*',
            DB::raw("(select count('tutors.bank_code') FROM tutors where tutors.bank_code = banks.bank_code) as tutor_count")
        )->withTranslation();
    
        if (!empty($data['search'])) {
            $query->whereTranslationLike('bank_name', 'like', '%' . $data['search']  . '%');
        }
        
        $limit = $request['size'] ?? config('repository.pagination.limit');
        return $query->paginate($limit);
    }

    /**
     * Method delete Bank Details
     * 
     * @param int $id 
     * 
     * @return void 
     */
    public function deleteBankDetails(int $id) 
    {
        $bankData = $this->getById($id);
        $data = Tutor::where('bank_code', $bankData['bank_code'])->first();
        if ($data) {
            throw new Exception(trans('error.tutor_already_add'));
        }
        return $this->delete($id);
    }
}