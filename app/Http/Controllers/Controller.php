<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Method apiSuccessResponse
     *
     * @param array|null $data    [explicite description]
     * @param string     $message [explicite description]
     *
     * @return JsonResponse
     */
    function apiSuccessResponse($data = null, $message = '')
    {
        return response()->json(
            [
                'success' => true, 
                'data' => $data, 
                'message' => $message
            ]
        );
    }
        
    /**
     * Method apiErrorResponse
     *
     * @param string $message   [explicite description]
     * @param int    $errorCode [explicite description]
     * @param mixed  $data      [explicite description]
     *
     * @return JsonResponse
     */
    function apiErrorResponse(
        string $message = '',
        int $errorCode = 422,
        $data = []
    ) {
        $response = [
            'success' => false, 
            'error' => [
                'message' => $message
            ]
        ];
        if ($data) {
            $response['data'] = $data;
        }
        return response()->json($response, $errorCode);
    }

    /**
     * Method apiSuccessResponse
     * 
     * @return JsonResponse
     */
    function apiDeleteResponse()
    {
        return response()->json([], 204);
    }
}
