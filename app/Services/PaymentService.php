<?php

namespace App\Services;

use GuzzleHttp;
use App\Models\Transaction;
use App\Gateways\Payments\HyperPayPaymentClient;

class PaymentService
{
   
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct() 
    {
       
    }

    /**
     * Method storCart
     * 
     * @param Array $data 
     * 
     * @return Json
     */
    public function storeCard($data)
    {
        /** 
         * Load payment method
         * 
         * @var object $client 
         */
        $client = $this->getGateway($data['gateway']);
        return $client->storeCard($data);
    }

    /**
     * Method deleteCard
     * 
     * @param array $data 
     * 
     * @return Json
     */
    public function deleteCard($data)
    {
        /** 
         * Load payment method
         * 
         * @var object $client 
         */
        $client = $this->getGateway($data['gateway']);
        return $client->deleteCard($data);
    }

    /**
     * Method authorization used to pay with save card
     * 
     * @param Array $data 
     * 
     * @return array
     */
    public function authorization($data)
    {
        /** 
         * Load payment method
         * 
         * @var object $client 
         */
        $client = $this->getGateway($data['gateway']);
        return $client->authorization($data);
    }

    /**
     * Method paymentWithNewCard used to pay with new card
     * 
     * @param Array $data 
     * 
     * @return Array
     */
    public function paymentWithNewCard($data)
    {
        /** 
         * Load payment method
         * 
         * @var object $client 
         */
        $client = $this->getGateway($data['gateway']);
        return $client->paymentWithNewCard($data);
    }

    /**
     * Method recurringPayment used to subscription
     * 
     * @param array $data 
     * 
     * @return object
     */
    public function recurringPayment($data)
    {
        /** 
         * Load payment method
         * 
         * @var object $client 
         */
        $client = $this->getGateway($data['gateway']);
        return $client->recurringPayment($data);
    }

    /**
     * Method getGateway
     * 
     * @param string $gateway 
     * 
     * @return string
     */
    public function getGateway($gateway = '')
    {
        if (!$gateway) {
            $gateway = config('services.default_payment_gateway');
        }

        $client = null;
        switch ($gateway) {
        case Transaction::PAYMENT_GATEWAY_HYPERPAY:
            $client = new HyperPayPaymentClient();
            break;
        }

        return $client;
    }

    /**
     * Method checkout
     * 
     * @param Array $data 
     * 
     * @return String
     */
    public function generateCheckoutId($data)
    {
        $client = $this->getGateway();
        return $client->generateCheckoutId($data);
    }

    /**
     * Method checkout
     * 
     * @param Array $data 
     * 
     * @return String
     */
    public function getPaymentStatus($data)
    {
        $client = $this->getGateway();
        return $client->getPaymentStatus($data);
    }

    /**
     * Method checkout
     * 
     * @param Array $data 
     * 
     * @return String
     */
    public function tutorPayOut($data)
    {
        $client = $this->getGateway();
        return $client->tutorPayOut($data);
    }

}
