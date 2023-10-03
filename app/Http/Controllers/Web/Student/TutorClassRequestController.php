<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TutorClassRequestRepository;
use Auth;

class TutorClassRequestController extends Controller
{


    protected $tutorClassRequestRepository;
    /**
     * Function __construct
     *
     * @param TutorClassRequestRepository $tutorClassRequestRepository [explicite description]
   
     *
     * @return void
     */
    public function __construct(
        TutorClassRequestRepository $tutorClassRequestRepository
       
    ) {
        $this->tutorClassRequestRepository = $tutorClassRequestRepository;
       
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['currentPage'] = 'tutorclassRequest';
        $params['title'] = trans("labels.tutor_class_request");
        return view('frontend.student.tutor-class-request.index', $params);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }


    public function tutorClassRequestList(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $datas = $this->tutorClassRequestRepository->getAll($userId);
            $html = view(
                'frontend.student.tutor-class-request.list',
                ['datas' => $datas]
            )->render();
            return $this->apiSuccessResponse($html, trans('labels.classrequest_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }

    }


  


}
