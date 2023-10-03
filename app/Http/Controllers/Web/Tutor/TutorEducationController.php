<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\TutorEducationResource;
use App\Http\Requests\Tutor\AddEducationRequest;
use App\Repositories\TutorEducationRepository;
use App\Models\TutorEducation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Exception;

/**
 * Class for tutor education opration
 */
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
        $this->tutorEducationRepository = $tutorEducationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddEducationRequest $request)
    {
        try {
            
            $user = Auth::user();
            $data = $request->all();
            if (empty(@$data['ar']['degree'])) {
                unset($data['ar']);
            }
            $data['tutor_id'] = $user->id;
            $data['certificate'] = @$data['education_certificate'];
            if (!empty($request->language)) {
                App::setLocale($request->language);
            }

            $result = $this->tutorEducationRepository->addEducation($data);
            return new TutorEducationResource($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     * @param int                      $id      [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TutorEducation $education 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TutorEducation $education)
    {
        try {
            $this->tutorEducationRepository->deleteEducation($education);
            return $this->apiSuccessResponse([], trans('message.education_deleted'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
}
