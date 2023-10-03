<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DemoRepository;
use App\Http\Requests\Admin\FaqRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Http\Resources\V1\DemoResource;


class DemoController extends Controller
{

    protected $demoRepository;
    /**
     * Function __construct
     *
     * @param DemoRepository $demoRepository [explicite description]
     * 
     * @return void
     */
    public function __construct(DemoRepository $demoRepository)
    {
        $this->demoRepository = $demoRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            return view('admin.demo.demo');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $demo = null;
        return view('admin.demo.add-update-demo', compact('demo'));
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
    //    return $request;

       try {
        $post = $request->all();
        $result = $this->demoRepository->createDemo($post);
        if (!empty($result)) {
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('message.add_demo')
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

        try {
            $demo = $this->demoRepository->getdemo($id);
            if (!empty($demo)) {
                return view('admin.demo.add-update-demo', compact('demo'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
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
        try {
            $post = $request->all();
            $result = $this->demoRepository->demoUpdate($post, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.update_demo')
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $result = $this->demoRepository->deletedemo($id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.delete_demo')
                    ]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function demoList(Request $request)
    {
          $post = $request->all();
          $data = $this->demoRepository->getdemos($post);
          return DemoResource::collection($data);
    }
}
