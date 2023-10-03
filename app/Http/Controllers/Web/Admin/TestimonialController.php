<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TestimonialRepository;
use App\Http\Requests\Admin\TestimonialAddUpdateRequest;
use App\Http\Resources\V1\TestimonialResource;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * TestimonialController Controller
 */
class TestimonialController extends Controller
{

    protected $testimonialRepository;

    /**
     * Method __construct
     * 
     * @param TestimonialRepository $testimonialRepository 
     * 
     * @return void 
     */
    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.testimonial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $testimonial = null;
        return view('admin.testimonial.add-update-testimonial', compact('testimonial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestimonialAddUpdateRequest $request 
     * 
     * @return Response
     */
    public function store(TestimonialAddUpdateRequest $request)
    {
        try {
            $post = $request->all();
            $result = $this->testimonialRepository->createTestimonial($post);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.add_testimonial')
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
     * @param int $id 
     * 
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $testimonial = $this->testimonialRepository->getTestimonial($id);
            if (!empty($testimonial)) {
                return view('admin.testimonial.add-update-testimonial', compact('testimonial'));
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
     * @param Request $request 
     * @param int     $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = $request->all();
            $result = $this->testimonialRepository->updateTestimonial($post, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.update_testimonial')
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
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->testimonialRepository->deleteTestimonial($id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.delete_testimonial')
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
     * Method Testimonial List
     * 
     * @param Request $request 
     * 
     * @return void 
     */
    public function testimonialList(Request $request)
    {
        $post = $request->all();
        $data = $this->testimonialRepository->getTestimonials($post);
        return TestimonialResource::collection($data);
    }

  

}
