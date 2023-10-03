<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\TutorPayoutRepository;
class WebHookController extends Controller
{
    protected $tutorPayoutRepository;
    
    /**
     * Method __construct
     *
     * @param TutorPayoutRepository $tutorPayoutRepository 
     *
     * @return void
     */
    public function __construct(TutorPayoutRepository $tutorPayoutRepository) 
    {
        $this->tutorPayoutRepository = $tutorPayoutRepository;
    }

    /**
     * Method index
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function index(Request $request)
    {
        $key_from_configuration = config('services.webhook_url_key');
        
        $key = hex2bin($key_from_configuration);
        $iv = hex2bin($request->header('X-Initialization-Vector'));
        $auth_tag = hex2bin($request->header('X-Authentication-Tag'));
        $cipher_text = hex2bin($request->getContent());
        
        $result = openssl_decrypt($cipher_text, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $auth_tag);

        Log::channel('webhook')
            ->info("web hook response ", ["data" => $result]);
    }

    /**
     * Method webhookSplit
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function webhookSplit(Request $request)
    {        
        $key_from_configuration = config('services.webhook_split_url_key');
        
        $key = hex2bin($key_from_configuration);
        $iv = hex2bin($request->header('X-Initialization-Vector'));
        $auth_tag = hex2bin($request->header('X-Authentication-Tag'));
        
        $data = json_decode($request->getContent());
        $cipher_text = hex2bin($data->encryptedBody);
        
        $result = openssl_decrypt($cipher_text, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $auth_tag);
        $result = json_decode($result);
        if ($result) {
            if ($result->status) {
                $params["status"] = 'success';
            } else {
                $params["status"] = 'failed';
            }
            if (!empty($result->data) && !empty($result->data->transactions)) {
                $this->tutorPayoutRepository->payoutUpdate(
                    $params,
                    $result->data->transactions[0]->merchantTransactionId
                );
            }
        }

        Log::channel('webhookSplit')
            ->info("web hook response ", ["data" => $result]);
        
    }
}
