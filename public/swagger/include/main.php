<?php

$config = include_once 'config.php';

$account = include_once 'account.php';
$user = include_once 'user.php';
$certificates = include_once 'certificates.php';
$educations = include_once 'educations.php';
$class = include_once 'class.php';
$master = include_once 'master.php';
$paymentMethods = include_once 'payment-methods.php';
$message = include_once 'message.php';
$notification = include_once 'notification.php';
$blogs = include_once 'blogs.php';
$topics = include_once 'topics.php';
$student = include_once 'student.php';
$tutor = include_once 'tutor.php';
$bookings = include_once 'booking.php';
$rating = include_once 'rating.php';
$cart = include_once 'cart.php';
$wallet = include_once 'wallet.php';
$transaction = include_once 'transaction.php';
$subscription = include_once 'subscription.php';
$raiseHand = include_once 'raise-hand.php';
$extraHours = include_once 'extra-hours.php';
$topUp = include_once 'topUp.php';


$array = array_merge(
    $master['paths'],
    $account['paths'],
    $user['paths'],
    $certificates['paths'],
    $educations['paths'],
    $class['paths'],
    $raiseHand['paths'],
    $bookings['paths'],
    $paymentMethods['paths'],
    $message['paths'],
    $notification['paths'],
    $blogs['paths'],
    $topics['paths'],
    $student['paths'],
    $tutor['paths'],
    $rating['paths'],
    $cart['paths'],
    $wallet['paths'],
    $transaction['paths'],
    $subscription['paths'],
    $extraHours['paths'],
    $topUp['paths'],
);
$definitions = array_merge(
    $master['definitions'],
    $account['definitions'],
    $user['definitions'],
    $certificates['definitions'],
    $educations['definitions'],
    $raiseHand['definitions'],
    $class['definitions'],
    $bookings['definitions'],
    $paymentMethods['definitions'],
    $message['definitions'],
    $notification['definitions'],
    $blogs['definitions'],
    $topics['definitions'],
    $student['definitions'],
    $tutor['definitions'],
    $rating['definitions'],
    $cart['definitions'],
    $wallet['definitions'],
    $transaction['definitions'],
    $subscription['definitions'],
    $extraHours['definitions'],
    $topUp['definitions'],
);
$json = [
    "swagger" => $config['swaggerVersion'],
    "info" => [
        "version" => $config['apiVersion'],
        "title" => $config['title']
    ],
    "host" => $config['base'],
    "basePath" => $config['basePath'],
    "schemes" => $config['schemes'],
    "tags" => [
        [
            "name" => 'master',
            "description" => "All master list api"
        ],
        [
            "name" => 'account',
            "description" => "All account api"
        ],
        [
            "name" => 'user',
            "description" => "All user related api"
        ],
        [
            "name" => 'student',
            "description" => "All student related api"
        ],
        [
            "name" => 'tutor',
            "description" => "All tutor related api"
        ],
        [
            "name" => 'tutor-certificates',
            "description" => "Tutor certificates api"
        ],
        [
            "name" => 'tutor-educations',
            "description" => "Tutor educations api"
        ],
        [
            "name" => 'class',
            "description" => "Classes apis"
        ],
        [
            "name" => 'raise-hand',
            "description" => "Raise hands in class apis"
        ],
        [
            "name" => 'bookings',
            "description" => "Class and webinar booking apis"
        ],
        [
            "name" => 'blogs',
            "description" => "Class blogs apis"
        ],
        [
            "name" => 'topics',
            "description" => "Class topics apis"
        ],
        [
            "name" => 'payment-methods',
            "description" => "All Payment methods related api"
        ],
        [
            "name" => 'rating',
            "description" => "Rating and review related apis"
        ],
        [
            "name" => 'message',
            "description" => "All message related api"
        ],
        [
            "name" => 'notification',
            "description" => "All notification related api"
        ],
        [
            "name" => 'cart',
            "description" => "All cart related api"
        ],
        [
            "name" => 'wallet',
            "description" => "All wallet related api"
        ],
        [
            "name" => 'transaction',
            "description" => "All transaction related api"
        ],
        [
            "name" => 'subscription',
            "description" => "All subscription related api"
        ],
        [
            "name" => 'extra-hours',
            "description" => "Extra hours in class apis"
        ],
        [
            "name" => 'top-up',
            "description" => "All top up related apis"
        ],
    ],
    'paths' => $array,
    'securityDefinitions' => [
        'Bearer' => [
            'type' => 'apiKey',
            'name' => 'authorization',
            'in' => 'header'
        ]
    ],
    'definitions' => $definitions,

];
echo json_encode($json);
