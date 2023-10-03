<?php
namespace App\Repositories;

use App\Models\TutorCertificate;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TutorCertificateRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return TutorCertificate::class;
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
     * @return TutorCertificate
     * @throws ModelNotFoundException|Exception
     */
    public function findCertificate(int $id)
    {
        try {
            return $this->find($id);
        } catch(ModelNotFoundException $e) {
            throw new ModelNotFoundException(
                trans('error.certificate_not_found'),
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
    public function getCertificates(array $params = [])
    {
        $query = $this->withTranslation();

        if (!empty($params['tutor_id'])) {
            $query->where('tutor_id', $params['tutor_id']);
        }

        return $query->paginate();
    }
        
    /**
     * Method addTutor
     *
     * @param array $data [explicite description]
     *
     * @return TutorCertificate
     */
    public function addCertificate(array $data):TutorCertificate
    {
        try {
            DB::beginTransaction();
            if (!empty($data['certificate'])) {
                $data['certificate'] = uploadFile(
                    $data['certificate'],
                    'tutor/certificates'
                );
            }
    
            $certificate = $this->create($data);
            DB::commit();
            return $certificate;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Method deleteCertificate
     *
     * @param TutorCertificate $certificate [explicite description]
     *
     * @return int
     */
    public function deleteCertificate(TutorCertificate $certificate):int
    {
        $certificateFile = $certificate->certificate;
        
        $deleted = $this->delete($certificate->id);
        if ($deleted) {
            deleteFile($certificateFile);
        }
        return $deleted;
    }
}