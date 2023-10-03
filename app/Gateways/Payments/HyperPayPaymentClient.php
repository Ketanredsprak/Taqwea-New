<?php

namespace App\Gateways\Payments;
use GuzzleHttp\Client;
use Exception;
use Log;
use App\Exceptions\HyperPayException;
use Illuminate\Support\Facades\Auth;
use App\Gateways\Payments\PaymentGatewayInterface;
use App\Models\Transaction;

/**
 * Class HyperPaymentClient
 */
class HyperPayPaymentClient implements PaymentGatewayInterface
{

    protected $apiUrl;

    protected $token;

    protected $entityIdMada;

    protected $entityIdMaster;

    protected $header;
    
    protected $returnUrl;

    protected $email;

    protected $name;

    protected $paymentType;

    protected $currency;

    protected $billingStreet1;

    protected $billingCity;

    protected $billingState;

    protected $billingCountry;

    protected $billingPostcode;

    protected $successCode;

    protected $successCodeApi;

    protected $apiPayoutUrl;

    /**
     * Method __construct
     * 
     * @return void
     */
    public function __construct()
    {
        $this->apiUrl = config('services.hyper_pay_api_url');
        $this->apiPayoutUrl = config('services.hyper_payout_api_url');
        $this->token = config('services.hyper_pay_access_token');
        $this->entityIdMada = config('services.hyper_pay_entity_id_mada');
        $this->entityIdMaster = config('services.hyper_pay_entity_id_visa_master');
        $this->returnUrl = config('app.url');

        $this->header = array(
            'Authorization' => 'Bearer '.$this->token
        );
        $this->testMode = false;
        $this->paymentType = "DB";
        $this->currency = config('app.currency.default');
        $this->successCode = config('constants.hyper_pay_success_code');
        $this->successCodeApi = config('constants.hyper_pay_success_code_api');

        /**
         * Billing address
         */
        $this->billingStreet1 = '8578 Abdulkarim Ibn Juhaiman';
        $this->billingCity = 'Jeddah';
        $this->billingState = 'Makkah';
        $this->billingCountry = 'SA';
        $this->billingPostcode = '23235';

        $this->payoutHeader = array(
            'Authorization' => 'Bearer '.config('services.hyper_payout_access_token'),
            'Content-Type' => 'application/json'
        );
        

        if (Auth::check()) {
            $user = Auth::user();
            $this->email = $user->email;
            $this->name = $user->name;
        }
       
    }

    /**
     * Method save card
     * 
     * @param Array $data 
     * 
     * @return Array
     */
    public function storeCard($data)
    {
        $url = $this->apiUrl."/v1/registrations";
        if ($data['card_type']=='MADA') {
            $requestData['entityId'] = $this->entityIdMada;
        } else {
            $requestData['entityId'] = $this->entityIdMaster;
        }
       
        $requestData['paymentBrand'] = $data['card_type'];
        $requestData['card.number'] = $data['card_number'];       
        $requestData['card.expiryMonth'] = $data['exp_month'];
        $requestData['card.expiryYear'] = $data['exp_year'];
       
        if ($data['card_type']=='APPLEPAY') {
            $requestData['threeDSecure.verificationId'] = $data['verification_id'];
            $requestData['threeDSecure.eci'] = $data['eci'];
            $requestData['applePay.source'] = $data['source'];
        } else {
            $requestData['card.holder'] = $data['card_holder_name'];
            $requestData['card.cvv'] = $data['card_cvv'];
        }

        try {
            $client = new Client();
            $responseData = $client->request(
                'post', $url,
                [
                    "headers" => $this->header,
                    "form_params" => $requestData, 
                ]
            );
            $gateWayResponse = json_decode($responseData->getBody());
            if (!empty($gateWayResponse->id)) {
                $data["card_id"] = $gateWayResponse->id;
                $data["card_number"] = $gateWayResponse->card->last4Digits;
                $data['brand'] = $data["card_type"]?? '';
                return $data;
            } else {
                throw new Exception(
                    ucwords($gateWayResponse->result->description)
                );
            }
        } catch (Exception $e) {
            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
        
    }

    /**
     * Method deleteCard
     * 
     * @param Array $data 
     * 
     * @return void
     */
    public function deleteCard($data)
    {

        if ($data["brand"] == 'MADA') {
            $data['entityId'] = $this->entityIdMada;
        } else {
            $data['entityId'] = $this->entityIdMaster;
        }

        $url = $this->apiUrl."/v1/registrations/".$data['cardId'];
        $url .= "?entityId=".$data['entityId'];
       
        try {
            $client = new Client();

            $responseData = $client->request(
                'DELETE', $url,
                [
                    "headers" => $this->header
                ]
            );
            return $responseData->getBody();
        } catch (Exception $e) {
            throw new HyperPayException(
                trans('hyperpay.'.$responseData->result->code)
            );
        }
       
    }

    /**
     * Method authorization
     * 
     * @param Array $data 
     * 
     * @return Array
     */
    public function authorization($data)
    {
      
        if ($data["card_type"] == 'MADA') {
            $data['entityId'] = $this->entityIdMada;
        } else {
            $data['entityId'] = $this->entityIdMaster;
        }

        $url = $this->apiUrl."/v1/registrations/".$data['card_id'].'/payments';
        
        if ($this->testMode) {
            $requestData['testMode'] = 'EXTERNAL';
        }
        
        $requestData['entityId'] = $data['entityId'];
        $requestData['customer.email'] = $this->email;
        $requestData['customer.givenName'] = $this->name;
        $requestData['merchantTransactionId'] = $data['merchantTransactionId'];
        $requestData['amount'] = number_format($data['amount'], 2, '.', '');       
        $requestData['currency'] = $data['currency'];
        $requestData['paymentType'] = $this->paymentType;
        $requestData['shopperResultUrl'] = $this->returnUrl;
        if (isset($data["subscription"])) {
            $requestData['standingInstruction.mode'] = 'INITIAL';
            $requestData['standingInstruction.type'] = 'UNSCHEDULED';
            $requestData['standingInstruction.source'] = 'CIT';
        }
           

        try {
            $client = new Client();

            $responseData = $client->request(
                'post', $url,
                [
                    "headers" => $this->header,
                    "form_params" => $requestData, 
                ]
            );
    
            $gateWayResponse = json_decode($responseData->getBody());
    
            if (!empty($gateWayResponse->id)) {
                if ($gateWayResponse->result->code == $this->successCode) {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'success';
                    $data['response_data'] = $responseData->getBody();
                   
                } else {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'failed';
                    $data['response_data'] = $responseData->getBody();

                }
                return $data;
            } 
        }  catch (Exception $e) {
            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
     
    }

    /**
     * Method paymentWithNewCard
     * 
     * @param Array $data  
     * 
     * @return Array
     */
    public function paymentWithNewCard($data)
    {
        if ($data["card_type"] == 'MADA') {
            $data['entityId'] = $this->entityIdMada;
        } else {
            $data['entityId'] = $this->entityIdMaster;
        }

        $url =  $this->apiUrl.'/v1/payments';

        if ($this->testMode) {
            $requestData['testMode'] = 'EXTERNAL';
        }

        $requestData['currency'] = $data['currency'];


        $requestData['customer.email'] = $this->email;
        $requestData['customer.givenName'] = $this->name;

        $requestData['shopperResultUrl'] = $this->returnUrl;

        $requestData['entityId'] = $data['entityId'];
        $requestData['merchantTransactionId'] = $data['merchantTransactionId'];

        $requestData['amount'] = number_format($data['amount'], 2, '.', '');      
        $requestData['paymentBrand'] = $data["card_type"];
        $requestData['paymentType'] = $this->paymentType;

        $requestData['card.number'] = $data['card_number'];
        $requestData['card.holder'] = $data['card_holder_name'];
        $requestData['card.expiryMonth'] = $data['exp_month'];
        $requestData['card.expiryYear'] = $data['exp_year'];
        $requestData['card.cvv'] = $data['cvv'];
       
        if ($data['is_card_save'] == 1) {
            $requestData['createRegistration'] = true;
        }
        
        if (isset($data["subscription"])) {
            $requestData['standingInstruction.mode'] = 'INITIAL';
            $requestData['standingInstruction.type'] = 'UNSCHEDULED';
            $requestData['standingInstruction.source'] = 'CIT';

            if (!$data['is_card_save']) {
                $requestData['createRegistration'] = true;
            }
        }

        try {
            $client = new Client();

            $responseData = $client->request(
                'POST', $url,
                [
                    "headers" => $this->header,
                    "form_params" => $requestData, 
                ]
            );
    
            $gateWayResponse = json_decode($responseData->getBody());
    
            if (!empty($gateWayResponse->id)) {
                if ($gateWayResponse->result->code == $this->successCode) {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'success';
                    $data['response_data'] = $responseData->getBody();
                    if ($data['is_card_save'] == 1) {
                        if (isset($gateWayResponse->registrationId) 
                            && !empty($gateWayResponse->registrationId)
                        ) {
                            $data['card_id'] = $gateWayResponse->registrationId;
                            $data["card_number"] = $gateWayResponse
                                ->card->last4Digits;
                        }
                    } elseif (!$data['is_card_save']
                        && isset($gateWayResponse->registrationId)
                    ) {
                        $data['card_id'] = $gateWayResponse->registrationId; 
                    }
                   
                } else {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'failed';
                    $data['response_data'] = $responseData->getBody();

                }
                return $data;
            } 
        }  catch (Exception $e) {
            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
    }

    /**
     * Method authorization
     * 
     * @param Array $data 
     * 
     * @return Array
     */
    public function recurringPayment($data)
    {
        if ($data["card_type"] == 'MADA') {
            $data['entityId'] = $this->entityIdMada;
        } else {
            $data['entityId'] = $this->entityIdMaster;
        }
        if ($this->testMode) {
            $requestData['testMode'] = 'EXTERNAL';
        }
        $url = $this->apiUrl."/v1/registrations/".$data['card_id'].'/payments';
       
        $requestData['entityId'] = $data['entityId'];
        $requestData['amount'] = number_format((float)$data['total_amount'], 2, '.', '');     
        $requestData['currency'] = $this->currency;
        $requestData['paymentType'] = $this->paymentType;
        $requestData['shopperResultUrl'] = $this->returnUrl;
        $requestData['merchantTransactionId'] = $data['merchantTransactionId'];

        $requestData['standingInstruction.mode'] = 'REPEATED';
        $requestData['standingInstruction.type'] = 'UNSCHEDULED ';
        $requestData['standingInstruction.source'] = 'MIT';

        //  Billing address
        $requestData['billing.street1'] = $this->billingStreet1;
        $requestData['billing.city'] = $this->billingCity;
        $requestData['billing.state'] = $this->billingState;
        $requestData['billing.country'] = $this->billingCountry;
        $requestData['billing.postcode'] = $this->billingPostcode;
        $requestData['customer.email'] = $data['email'];
        $requestData['customer.givenName'] = $data['givenName'];

        try {
            $client = new Client();

            $responseData = $client->request(
                'post', $url,
                [
                    "headers" => $this->header,
                    "form_params" => $requestData, 
                ]
            );
    
            $gateWayResponse = json_decode($responseData->getBody());
            if (!empty($gateWayResponse->id)) {
                if ($gateWayResponse->result->code == $this->successCode
                    || $gateWayResponse->result->code == $this->successCodeApi
                ) {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'success';
                    $data['response_data'] = $responseData->getBody();
                   
                } else {
                    $data['transaction_id'] = $gateWayResponse->id;
                    $data['status'] = 'failed';
                    $data['response_data'] = $responseData->getBody();

                }

                if (isset($gateWayResponse->registrationId) 
                    && !empty($gateWayResponse->registrationId)
                ) {
                    $data['card_id'] = $gateWayResponse->registrationId;
                    $data["brand"] = $gateWayResponse->paymentBrand;
                }

                return $data;
            } 
        }  catch (Exception $e) {
            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
     
    }

    /**
     * Method checkout
     * 
     * @param Object $data 
     * 
     * @return string 
     */
    public function generateCheckoutId($data)
    {
        $url = $this->apiUrl."/v1/checkouts";
        if ($data->card_type == 'MADA') {
            $entityId = $this->entityIdMada;
            if ($this->testMode) {
                $requestData['testMode'] = 'EXTERNAL';
            }
        } else {
            $entityId = $this->entityIdMaster;
        }
        $requestData['entityId'] = $entityId;
        if (!empty($data->total_amount)) {
            $requestData['amount'] = number_format((float)$data->total_amount, 2, '.', '');
            $requestData['paymentType'] = $this->paymentType;
            $requestData['currency'] = $this->currency;
            $requestData['merchantTransactionId'] = $data->id;
            $requestData['customer.email'] = $this->email;
            $requestData['customer.givenName'] = $this->name;

            //  Billing address
            $requestData['billing.street1'] = $this->billingStreet1;
            $requestData['billing.city'] = $this->billingCity;
            $requestData['billing.state'] = $this->billingState;
            $requestData['billing.country'] = $this->billingCountry;
            $requestData['billing.postcode'] = $this->billingPostcode;

            if ($data->transaction_type == Transaction::STATUS_SUBSCRIPTION) {
                $requestData['standingInstruction.mode'] = 'INITIAL';
                $requestData['standingInstruction.type'] = 'UNSCHEDULED';
                $requestData['standingInstruction.source'] = 'CIT';
            }

            //Get user save card
            $user = Auth::user();
            if (!empty($user)) {
                foreach ($user->paymentMethods as $key=>$paymentMethod) {
                    $requestData['registrations['.$key.'].id'] 
                        = $paymentMethod->card_id;
                }
            }
            
        } else {
            $requestData['currency'] = $this->currency;
        }

        try {
            $client = new Client();
            $responseData = $client->request(
                'post', $url,
                [
                    "headers" => $this->header,
                    "form_params" => $requestData, 
                ]
            );
            $gateWayResponse = json_decode($responseData->getBody());
            if (!empty($gateWayResponse->id)) {
                return $gateWayResponse->id;
            } else {
                throw new Exception(
                    ucwords($gateWayResponse->result->description)
                );
            }
        } catch (Exception $e) {
            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
    }

    /**
     * Method getPaymentStatus
     * 
     * @param array $data 
     * 
     * @return string 
     */
    public function getPaymentStatus($data)
    {
        if ($data['card_type'] == 'MADA') {
            $entityId = $this->entityIdMada;
        } else {
            $entityId = $this->entityIdMaster;
        }

        $url = $this->apiUrl."".$data['resourcePath']."?entityId=".$entityId;
       
        try {
            $client = new Client();
            $responseData = $client->request(
                'get', $url,
                [
                    "headers" => $this->header                   
                ]
            );
            $gateWayResponse = json_decode($responseData->getBody());
            Log::channel('payments')
                ->info("Payment response", ["data" => $gateWayResponse]);

            if (!empty($gateWayResponse->id)) {
                $result['transaction_id'] = $gateWayResponse->id;
                $result['response_data'] = $responseData->getBody();
                $result['merchantTransactionId']
                    = $gateWayResponse->merchantTransactionId;

                if ($gateWayResponse->result->code == $this->successCode
                    || $gateWayResponse->result->code == $this->successCodeApi
                ) {
                    $result['status'] = Transaction::STATUS_SUCCESS;
                    if (isset($gateWayResponse->registrationId) 
                        && !empty($gateWayResponse->registrationId)
                    ) {
                        $result['card_id'] = $gateWayResponse->registrationId;
                        $result["card_number"] = $gateWayResponse
                            ->card->last4Digits;
                        $result["brand"] = $gateWayResponse
                            ->paymentBrand;
                        $result["exp_month"] = $gateWayResponse
                            ->card->expiryMonth;
                        $result["exp_year"] = $gateWayResponse
                            ->card->expiryYear;
                        $result["card_holder_name"] = $gateWayResponse
                            ->card->holder;
                    }

                } else {
                    $result['status'] = Transaction::STATUS_FAILED;
                }
                return $result;
            } else {
                throw new HyperPayException(
                    trans('hyperpay.'.$gateWayResponse->result->code)
                );
            }
        } catch (Exception $e) {
            if ($e instanceof HyperPayException) {
                throw $e;
            }

            $gateWayResponse = json_decode($e->getResponse()->getBody());
            throw new HyperPayException(
                trans('hyperpay.'.$gateWayResponse->result->code)
            );
        }
    }

    /**
     * Method tutorPayOut
     * 
     * @param array $params 
     * 
     * @return array
     */
    public function tutorPayOut($params)
    {
        
        $url = $this->apiPayoutUrl."/api/v1/orders";

        try {
            //$requestData['amount'] = number_format((float)$params['amount'], 2, '.', '');
            $requestData['merchantTransactionId'] = $params['transaction_id'];
            $requestData['configId'] = config('services.hyper_payout_config_id');
            $requestData['transferOption'] = "0";
            $requestData['period'] = date("Y-m-d");
            $requestData['batchDescription'] = "Accountant pay tutor amount";
            $requestData['beneficiary'][0]['name'] = $params['name'];
            $requestData['beneficiary'][0]['accountId'] = $params['account_id'];
            $requestData['beneficiary'][0]['transferAmount'] = number_format((float)$params['amount'], 2, '.', '');
            $requestData['beneficiary'][0]['debitCurrency'] = $this->currency;
            $requestData['beneficiary'][0]['transferCurrency'] = $this->currency;
            $requestData['beneficiary'][0]['bankIdBIC'] = $params["bank_id_bic"];
            $requestData['beneficiary'][0]['payoutBeneficiaryAddress1'] = $params["payout_beneficiary_address1"];
            $client = new Client();
            $responseData = $client->request(
                'post', $url,
                [
                    "headers" => $this->payoutHeader,
                    "body" => json_encode($requestData), 
                ]
            );
            $gateWayResponse = json_decode($responseData->getBody());
            if ($gateWayResponse->status) {
                $data["status"] = 'success';
                $data["transaction_id"] = $gateWayResponse->data->uniqueId;
                $data["payout_response"] = $responseData->getBody();
            } else {
                $data["status"] = 'failed';
                $data["payout_response"] = $responseData->getBody();
            }
            return $data;
        } catch (Exception $e) {
            throw $e;
        }
    }

}
