<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TutorRequestRepositoty; 
use App\Models\Category;
use App\Models\ClassRequestDetail;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\ClassQuotes;
use App\Models\ClassRequest;
use Auth;

class TutorClassRequestController extends Controller
{

    protected $tutorRequestRepositoty;
    /**
     * Function __construct
     *@param TutorRequestRepositoty     $tutorRequestRepositoty
     * @return void
     */
    public function __construct(
        TutorRequestRepositoty $tutorRequestRepositoty
    )
    {
        $this->tutorRequestRepositoty = $tutorRequestRepositoty;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['currentPage'] = 'TutorClassRequest';
        $params['title'] = trans("labels.class_request");
        return view('frontend.tutor.class-request.index', $params);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        try {
            $result = $this->tutorRequestRepositoty->gettutorRequest($id);
            if (!empty($result)) {
                   
                    $subject_data = Subject::withTranslation()->where('id', $result->classrequest->subject_id)->first();
                    $level = Category::withTranslation()->where('id', $result->classrequest->level_id)->first();
                    $grade = Grade::withTranslation()->where('id', $result->classrequest->grade_id)->first();
                    $class_details = ClassRequestDetail::where('class_request_id', $result->classrequest->id)->get();
                    

                $data['currentPage'] = 'classRequest';
                $data['title'] = trans("labels.class_request");
                $data['result'] = $result;
                $data['subject_data'] = $subject_data;
                $data['level'] = $level;
                $data['grade'] = $grade;
                $data['class_details'] = $class_details;
               

                return view('frontend.tutor.class-request.show', $data);
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tutorClassRequestList(Request $request)
    {
    
        try {
            $userId = Auth::user()->id;
            $tutorclassrequest = $this->tutorRequestRepositoty->gettutorclassrequest($userId);
            foreach($tutorclassrequest as $data)
            {
                    $check_tutro_send_quote = ClassQuotes::where('class_request_id',$data-> class_request_id)->where('tutor_id',$data->tutor_id)->count();
                    $data->tutor_quote= $check_tutro_send_quote;
            }
                           
            $html = view(
                'frontend.tutor.class-request.list',
                ['datas' => $tutorclassrequest]
            )->render();
            return $this->apiSuccessResponse($html, trans('labels.classrequest_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    

    }


}
