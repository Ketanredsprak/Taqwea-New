<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddCertificateRequest;
use App\Http\Resources\V1\TutorCertificateResource;
use App\Models\TutorCertificate;
use App\Models\User;
use App\Repositories\TutorCertificateRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TutorCertificateController extends Controller
{
    protected $tutorCertificateRepository;
    
    /**
     * Method __construct
     *
     * @param TutorCertificateRepository $tutorCertificateRepository 
     *
     * @return void
     */
    public function __construct(
        TutorCertificateRepository $tutorCertificateRepository
    ) {
        $this->authorizeResource(TutorCertificate::class, 'certificate');
        $this->tutorCertificateRepository = $tutorCertificateRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param User $tutor 
     *   
     * @return Collection
     */
    public function index(User $tutor)
    {
        try {
            $params['tutor_id'] = $tutor->id;
            $results = $this->tutorCertificateRepository->getCertificates($params);
            return TutorCertificateResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddCertificateRequest $request 
     * @param User                  $tutor 
     * 
     * @return Response
     */
    public function store(AddCertificateRequest $request, User $tutor)
    {
        try {
            $data = $request->all();
            $data['tutor_id'] = $tutor->id;
            $result = $this->tutorCertificateRepository->addCertificate($data);
            return new TutorCertificateResource($result);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User             $tutor 
     * @param TutorCertificate $certificate 
     * 
     * @return Response
     */
    public function destroy(
        User $tutor,
        TutorCertificate $certificate
    ) {
        try {
            $this->tutorCertificateRepository
                ->deleteCertificate($certificate);
            return $this->apiDeleteResponse();
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
}
