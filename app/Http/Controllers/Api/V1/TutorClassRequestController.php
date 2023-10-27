<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\ClassQuotes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\QuoteRequest;
use App\Repositories\TutorQuoteRepository;
use App\Repositories\TutorRequestRepositoty;
use App\Http\Resources\V1\TutorClassRequestResource;


class TutorClassRequestController extends Controller
{
    protected $tutorRequestRepositoty;
    protected $tutorQuoteRepository;
    /**
     * Function __construct
     *@param TutorRequestRepositoty     $tutorRequestRepositoty
     * @param TutorQuoteRepository $tutorQuoteRepository [explicite description]
     * @return void
     */
    public function __construct(
        TutorRequestRepositoty $tutorRequestRepositoty,
        TutorQuoteRepository $tutorQuoteRepository
    ) {
        $this->tutorRequestRepositoty = $tutorRequestRepositoty;
        $this->tutorQuoteRepository = $tutorQuoteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $userId = Auth::id();
            $tutorclassrequest = $this->tutorRequestRepositoty->gettutorclassrequest($userId);
            foreach ($tutorclassrequest as $data) {
                $check_tutro_send_quote = ClassQuotes::where('class_request_id', $data->class_request_id)->where('tutor_id', $data->tutor_id)->count();
                $data->tutor_quote = $check_tutro_send_quote;
            }
            return TutorClassRequestResource::collection($tutorclassrequest);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuoteRequest $request [explicite description]
     */
    public function store(QuoteRequest $request)
    {
     
        return "hello store funstion";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        try {
            $result = $this->tutorRequestRepositoty->gettutorRequest($id);
            $check_tutor_send_quote_1 = ClassQuotes::where('class_request_id', $result->class_request_id)->where('tutor_id', $result->tutor_id)->get();
            if(count($check_tutor_send_quote_1) == 1)
            {
                    $result['is_quote_sent'] = 1;
            }
            else {
                    $result['is_quote_sent'] = 0;
            }
            return TutorClassRequestResource::make($result);
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
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

    public function sendquote(QuoteRequest $request)
    {
      
        // $post = $request->all();
        try {
            $post = $request->all();
            $post['tutor_id'] = Auth::id();
            $post['user_type'] =  Auth::user()->user_type;
            $post['status'] = "0";
            $result = $this->tutorQuoteRepository->createTutorRequest($post);
            if (!empty($result)) {
                return $this->apiSuccessResponse([], trans('message.price_send'));
            }
            else
            {
                return $this->apiErrorResponse(trans('error.quote_already_send'),200);
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

}
