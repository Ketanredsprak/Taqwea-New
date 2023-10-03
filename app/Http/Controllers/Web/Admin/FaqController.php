<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FaqRepository;
use App\Http\Requests\Admin\FaqRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * FaqController class
 */
class FaqController extends Controller
{
    protected $faqRepository;
    /**
     * Function __construct
     *
     * @param FaqRepository $faqRepository [explicite description]
     * 
     * @return void
     */
    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.faqs.faq');
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
        $faq = null;
        try {
            return view('admin.faqs.add', compact('faq'));
        } catch (Exception $ex) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $ex->getMessage()
                ]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('faq_file')) {
                $data['mimeType'] = $request->file('faq_file')->getMimeType();
            }
            $this->faqRepository->createFaq($data);
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('message.add_faq')
                ]
            );
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
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
     * @return View
     */
    public function edit($id)
    {
        try {
            $faq = $this->faqRepository->getFaq($id);
            return view('admin.faqs.edit-faq', compact('faq'));
        } catch (Exception $ex) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $ex->getMessage()
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request [explicite description]
     * @param int     $id      [explicite description] 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('faq_file')) {
                $data['mimeType'] = $request->file('faq_file')->getMimeType();
            }
            $this->faqRepository->updateFaq($data, $id);
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('message.edit_faq')
                ]
            );
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
            $this->faqRepository->delete($id);
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('message.delete_faq')
                ]
            );
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Function filter
     *
     * @param Request $request [explicite description]
     * 
     * @return void
     */
    public function filter(Request $request)
    {
        $params = $request->all();
        $data = $this->faqRepository->getFaqs($params);
        if (!empty($data)) {
            return view(
                'admin.faqs.filter-faq',
                [
                    'faqData' => $data,
                    'meta' => ['total' => $data->total()]
                ]
            )->render();
        }
    }
}
