<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => ['api'],
        'namespace' => 'Api\V1',
        'prefix' => 'v1'
    ],
    function () {
        Route::group(
            [
                'middleware' => ['no.token']
            ],
            function () {
                Route::get(
                    'categories/all',
                    'CategoryController@allCategory'
                );

                Route::get(
                    'subjects',
                    'CategoryController@subjects'
                );
                Route::get(
                    'categories/grades',
                    'CategoryController@grades'
                );
                Route::apiResource('categories', CategoryController::class);

                Route::get(
                    'categories/{category}/levels',
                    'CategoryController@levels'
                );
                Route::get(
                    'categories/{category}/languages',
                    'CategoryController@languages'
                );
                Route::get(
                    'categories/{category}/general-knowledge',
                    'CategoryController@generalKnowledge'
                );

                Route::post('signup', 'AccountController@signup')->name('signup');
                Route::post('login', 'AccountController@login')->name('login');
                Route::post(
                    'social-login/{provider}',
                    'AccountController@socialLogin'
                )->name('social-login');
                Route::get(
                    'get-social-user',
                    'AccountController@getSocialUser'
                );
                Route::post('forgot-password', 'AccountController@forgotPassword');
                Route::post('reset-password', 'AccountController@resetPassword');
                Route::post('/send-otp', 'AccountController@sendOtp');
                Route::post('/verify-otp', 'AccountController@verify');
                Route::post('/web-push', 'NotificationController@webPush');
            }
        );

        Route::group(
            ['middleware' => 'jwtAuth'],
            function () {
                Route::post(
                    'users/{id}/complete-profile',
                    'UserController@completeProfile'
                );
                Route::post(
                    'users/set-lanaguage',
                    'UserController@setLanguage'
                );
                Route::post(
                    'users/{user}/support-request',
                    'UserController@supportRequest'
                );
                Route::get(
                    'users/{user}/ratings',
                    'RatingReviewController@userRatings'
                );
                Route::apiResource('users', UserController::class);

                Route::get(
                    'is-available-status',
                    'UserController@changeIsAvailbleStatus'
                )->name('is.available.status');
                
                Route::get(
                    'class-quote/{id}',
                    'ClassRequestController@classQuote'
                )->name('class.quote');

                Route::get(
                    'reject-class-quote/{id}',
                    'ClassRequestController@rejectClassQuote'
                )->name('reject.class.quote');
                Route::get(
                    'accept-class-quote/{id}',
                    'ClassRequestController@acceptClassQuote'
                )->name('accept.class.quote');

                Route::get(
                    'cancel-class-request/{id}',
                    'ClassRequestController@cancelrequest'
                )->name('cancel.class.request');

                Route::get(
                    'tutor-list/{id}',
                    'ClassRequestController@getTutorListForClassRequest'
                )->name('tutor.list');


                

                Route::apiResource(
                    'student-class-request',
                    ClassRequestController::class
                );

                Route::apiResource(
                    'tutor-class-request',
                    TutorClassRequestController::class
                );

                Route::post(
                    'tutor-quote-send',
                    'TutorClassRequestController@sendquote'
                );

                Route::apiResource(
                    'tutors.certificates',
                    TutorCertificateController::class
                );

                Route::apiResource(
                    'tutors.educations',
                    TutorEducationController::class
                );

                Route::get(
                    'classes/available',
                    'ClassController@availableDate'
                );

                Route::get(
                    'classes/token',
                    'ClassController@token'
                );

                Route::put(
                    'classes/{class}/{action}',
                    'ClassController@updateStatus'
                );

                Route::apiResource('classes', ClassController::class);

                Route::patch(
                    'classes/{class}/publish',
                    'ClassController@publish'
                );

                Route::post(
                    'classes/{class}/raise-dispute',
                    'ClassController@raiseDispute'
                );

                Route::get(
                    'blogs/download/{blog}',
                    'BlogController@download'
                );

                Route::get(
                    'blogs/purchase',
                    'BlogController@purchased'
                );

                Route::apiResource(
                    'blogs',
                    BlogController::class
                );
                Route::apiResource(
                    'classes.topics',
                    TopicController::class
                );

                Route::get(
                    'student/dashboard',
                    'StudentController@dashboard'
                );

                Route::get(
                    'tutor/dashboard',
                    'TutorController@dashboard'
                );
                Route::put(
                    'tutor/bank-account',
                    'TutorController@saveBankDetail'
                );

                Route::get(
                    'tutors',
                    'TutorController@index'
                );


                Route::apiResource(
                    'bookings',
                    BookingController::class
                );
                Route::put(
                    'bookings/{booking}/{action}',
                    'BookingController@updateStatus'
                );

                Route::get(
                    'bookings/student-list/{class}',
                    'BookingController@studentList'
                );

                Route::get(
                    'ratings/give-feedback',
                    'RatingReviewController@giveFeedback'
                );

                Route::apiResource(
                    'ratings',
                    RatingReviewController::class
                );

                Route::apiResource(
                    'classes.raise-hand',
                    RaiseHandConroller::class
                );

                Route::apiResource(
                    'classes.extra-hours',
                    ExtraHoursConroller::class
                );

                Route::patch(
                    'classes/{class}/update-extra-hours',
                    'ExtraHoursConroller@update'
                );

                Route::get(
                    '/notifications/clear-all',
                    'NotificationController@clearAll'
                );
                Route::patch(
                    '/notifications/read-all',
                    'NotificationController@readAll'
                );
                Route::apiResource('notifications', NotificationController::class);

                Route::post('/change-password', 'AccountController@changePassword');
                Route::post('logout', 'AccountController@logout');
                Route::apiResource('carts', CartController::class);
                Route::delete('carts/{id}/{item_id}', 'CartController@destroy');
                Route::apiResource('wallets', WalletController::class);

                Route::get('transactions/payment-history', 'TransactionController@payoutHistory');

                Route::apiResource('transactions', TransactionController::class);
                Route::post('/redeem-points', 'WalletController@redeemPoints');
                Route::apiResource('/payment-methods', PaymentController::class);
                Route::get(
                    '/subscriptions/purchases',
                    'SubscriptionController@purchased'
                );
                Route::apiResource('/subscriptions', SubscriptionController::class);
                Route::get(
                    '/top-ups/purchases',
                    'TopUpController@purchased'
                );
                Route::apiResource('/top-ups', TopUpController::class);
                Route::get(
                    '/messages/{uuid}/{studentId?}',
                    'MessageController@messageDetail'
                );
                Route::apiResource('/messages', MessageController::class);
                Route::apiResource('banks', BankController::class);
            }
        );

        Route::get(
            'settings',
            'SettingController@index'
        );
    }
);
