<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TransactionItemRepository;
use Exception;

class BlogController extends Controller
{
    protected $transactionItemRepository;
    
    /**
     * Method __construct
     * 
     * @param TransactionItemRepository $transactionItemRepository 
     *
     * @return void
     */
    public function __construct(
        TransactionItemRepository $transactionItemRepository
    ) {
        $this->transactionItemRepository = $transactionItemRepository;
    }


    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $data['currentPage'] = 'blogsPurchase';
        return view('frontend.student.blog.index', $data); 
    }

    /**
     * Method list
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return Json
     */
    public function list(Request $request)
    {
        try {
            $params['with_trashed'] = true;
            $blogs = $this->transactionItemRepository->getBogs($params);
            $html = view(
                'frontend.student.blog.blog-list',
                [
                    'blogs' => $blogs,
                ]
            )->render();
            return $this->apiSuccessResponse($html, trans('message.blog_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
