<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class is use for student cart 
 */
class CartController extends Controller
{
    protected $cartRepository;
    protected $cartItemRepository;
    protected $transactionRepository;

    /**
     * Method __construct
     * 
     * @param CartRepository     $cartRepository 
     * @param CartItemRepository $cartItemRepository 
     * @param CartItemRepository $transactionRepository 
     *
     * @return void
     */
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data['cart'] = $this->cartRepository->getCart($user->id);
        if (!empty($data['cart']) && count($data['cart']->items) > 0) {
            foreach ($data['cart']->items as $item) {
                if ($item) {
                    $item->is_available = $this->checkBookingItems(
                        [
                            'item_id' => $item->class_id,
                            'item_type' => $item->class_id ? 'class' : 'blog'
                        ]
                    );
                }
            }
        }
        return view('frontend.student.cart.index', $data);
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
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $params  = [];
            if ($request->item_type == 'class') {
                $params['class_id'] = $request->item_id;
            }

            if ($request->item_type == 'blog') {
                $params['blog_id'] = $request->item_id;
            }

            $this->cartRepository->createCart($params);
            return $this->apiSuccessResponse([], trans('message.add_to_cart'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
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
     * @param int $id 
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
     * @param \Illuminate\Http\Request $request 
     * @param int                      $id 
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
     * @param int $id 
     * @param int $item_id 
     * 
     * @return Json
     */
    public function destroy($id, $item_id)
    {
        try {
            $this->cartItemRepository->deleteItem($id, $item_id);
            return $this->apiSuccessResponse([], trans('message.item_deleted'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    public function checkBookingItems($data)
    {
        try {
            $this->transactionRepository->checkBookingItems($data);
            return array('success' => true, 'message' => '');
        } catch (Exception $e) {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
}
