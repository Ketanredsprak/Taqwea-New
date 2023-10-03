<?php
namespace App\Gateways\Payments;

interface PaymentGatewayInterface {
    public  function storeCard($data);
    public  function deleteCard($data);
    public  function authorization($data);
    public  function paymentWithNewCard($data);
    public  function recurringPayment($data);
    public  function generateCheckoutId($data);
    public  function getPaymentStatus($data);
    public  function tutorPayOut($data);
}