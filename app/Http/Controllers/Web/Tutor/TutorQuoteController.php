<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tutor\AddQuoteRequest;
use App\Repositories\TutorQuoteRepository;


class TutorQuoteController extends Controller
{

    protected $tutorQuoteRepository;
    /**
     * Function __construct
     *
     * @param TutorQuoteRepository $tutorQuoteRepository [explicite description]
     * 
     * @return void
     */
    public function __construct(TutorQuoteRepository $tutorQuoteRepository)
    {
        $this->tutorQuoteRepository = $tutorQuoteRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       return "hello";
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

        try {
            $post = $request->all();
            $post['status'] = "0";
            $result = $this->tutorQuoteRepository->createTutorRequest($post);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.price_send')
                    ]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
