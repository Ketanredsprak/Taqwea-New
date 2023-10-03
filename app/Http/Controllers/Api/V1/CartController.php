<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AddToCartRequest;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\CartResource;
/**
 * CartControllers
 */
class CartController extends Controller
{
    protected $cartRepository;

    protected $cartItemRepository;

    /**
     * Method __construct
     * 
     * @param CartRepository     $cartRepository 
     * @param CartItemRepository $cartItemRepository 
     *
     * @return void
     */
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $userId = Auth::user()->id;
            $cart = $this->cartRepository->getCart($userId);
            return new CartResource($cart);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddToCartRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        try {
            $data = $request->all();
            $user['user_id'] = Auth::user()->id;
            $this->cartRepository->createCart($data, $user);
            return $this->apiSuccessResponse([], trans('message.add_to_cart'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
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
     * @param  int                       $id 
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
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
}
