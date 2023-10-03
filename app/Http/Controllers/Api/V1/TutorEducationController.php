<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddEducationRequest;
use App\Http\Resources\V1\TutorEducationResource;
use App\Models\TutorEducation;
use App\Models\User;
use App\Repositories\TutorCertificateRepository;
use App\Repositories\TutorEducationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TutorEducationController extends Controller
{
    protected $tutorEducationRepository;
    
    /**
     * Method __construct
     *
     * @param TutorCertificateRepository $tutorEducationRepository 
     *
     * @return void
     */
    public function __construct(
        TutorEducationRepository $tutorEducationRepository
    ) {
        $this->authorizeResource(TutorEducation::class, 'education');
        $this->tutorEducationRepository = $tutorEducationRepository;
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
            $results = $this->tutorEducationRepository->getEducations($params);
            return TutorEducationResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddEducationRequest $request 
     * @param int                 $tutorId 
     * 
     * @return Response
     */
    public function store(AddEducationRequest $request, int $tutorId)
    {
        try {
            $data = $request->all();
            $data['tutor_id'] = $tutorId;
            $result = $this->tutorEducationRepository->addEducation($data);
            return new TutorEducationResource($result);
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
     * @param User           $tutor 
     * @param TutorEducation $education 
     * 
     * @return Response
     */
    public function destroy(User $tutor, TutorEducation $education)
    {
        try {
            $this->tutorEducationRepository
                ->deleteEducation($education);
            return $this->apiDeleteResponse();
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
}
