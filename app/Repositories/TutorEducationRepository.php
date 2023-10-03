<?php
namespace App\Repositories;

use App\Models\TutorEducation;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TutorEducationRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return TutorEducation::class;
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
     * Method findCertificate
     *
     * @param int $id [explicite description]
     *
     * @return TutorEducation
     * @throws ModelNotFoundException|Exception
     */
    public function findEducation(int $id)
    {
        try {
            return $this->find($id);
        } catch(ModelNotFoundException $e) {
            throw new ModelNotFoundException(
                trans('error.education_not_found'),
                404
            );
        } catch (Exception $e) {
            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Method findCertificate
     *
     * @param array $where [explicite description]
     *
     * @return TutorEducation
     * @throws ModelNotFoundException|Exception
     */
    public function findOne(array $where)
    {
        try {
            return $this->where($where)->first();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(
                trans('error.education_not_found'),
                404
            );
        } catch (Exception $e) {
            throw new Exception(trans('error.server_error'));
        }
    }


    /**
     * Method getCertificates
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getEducations(array $params = [])
    {
        $query = $this->withTranslation();

        $query->where('tutor_id', $params['tutor_id']);
        
        return $query->paginate();
    }
        
    /**
     * Method addTutor
     *
     * @param array $data [explicite description]
     *
     * @return TutorEducation
     */
    public function addEducation(array $data):TutorEducation
    {
        try {
            DB::beginTransaction();
            if (!empty($data['certificate'])) {
                $data['certificate'] = uploadFile(
                    $data['certificate'],
                    'tutor/education'
                );
            }
    
            $education = $this->create($data);
            DB::commit();
            return $education;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Method deleteCertificate
     *
     * @param TutorEducation $education [explicite description]
     *
     * @return int
     */
    public function deleteEducation(TutorEducation $education):int
    {
        $educationFile = $education->certificate;
        //$user = Auth::user();
        // if (!$user->can('delete', $education)) {
        //     throw new Exception(trans('error.delete_not_allowed'));
        // }
        $deleted = $this->delete($education->id);
        if ($deleted) {
            deleteFile($educationFile);
        }
        return $deleted;
    }
}