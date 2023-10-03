<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TutorCertificateRepository;
use App\Http\Resources\V1\TutorCertificateResource;
use Illuminate\Support\Facades\App;
use App\Models\TutorCertificate;
use Exception;
use App\Http\Requests\Tutor\AddCertificateRequest;

/**
 * Class for tutor certificate opration
 */
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
        $this->tutorCertificateRepository = $tutorCertificateRepository;
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
     * @param AddCertificateRequest $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddCertificateRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();
            if (empty(@$data['ar']['certificate_name'])) {
                unset($data['ar']);
            }

            $data['tutor_id'] = $user->id;
            if (!empty($request->language)) {
                App::setLocale($request->language);
            }

            $result = $this->tutorCertificateRepository->addCertificate($data);
            return new TutorCertificateResource($result);
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
     * @param TutorCertificate $certificate [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TutorCertificate $certificate)
    {
        try {
            $this->tutorCertificateRepository
                ->deleteCertificate($certificate);
            return $this->apiSuccessResponse([], trans('message.certificate_deleted'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
}
