<?php

/**
 * --------------------------------------------------------------------------
 * Tutor Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register tutor routes for your application.
 */

use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['web', 'tutor:web']],
    function () {
        Route::get(
            'registration-complete',
            'Web\Tutor\DashboardController@registrationComplete'
        )->name('tutor/complete/registration');

        Route::get(
            'verification-pending',
            'Web\Tutor\DashboardController@verificationPendig'
        )->name("tutor.verification-pending");

        // Complete Profile Routes
        Route::get(
            'complete-profile',
            'Web\Tutor\CompleteProfileController@index'
        )->name('tutor/complete/profile');
        Route::get(
            'profile',
            'Web\Tutor\CompleteProfileController@getDetails'
        )->name('tutor/profile');
        Route::post(
            '/{id}/personal-details',
            'Web\Tutor\CompleteProfileController@completeProfile'
        )->name('tutor/personal-details');
        Route::post(
            '/{id}/professional-details',
            'Web\Tutor\CompleteProfileController@saveProfessionalDetail'
        )->name('tutor/professional-details');
        Route::resource('educations', 'Web\Tutor\TutorEducationController');
        Route::resource('certificates', 'Web\Tutor\TutorCertificateController');
        Route::get(
            '/send-for-approval',
            'Web\Tutor\CompleteProfileController@sendForApproval'
        )->name('tutor/send-for-approval');
        Route::group(
            ['middleware' => ['tutorVerification']],
            function () {

                /**
                 * Check tutor wallet balance
                 */
                Route::group(
                    ['middleware' => ['tutorWalletBalanceCheck']],
                    function () {
                        Route::get('/', 'Web\Tutor\DashboardController@index');
                        Route::get(
                            'dashboard',
                            'Web\Tutor\DashboardController@index'
                        )->name('tutor/dashboard');
        
                        Route::get('blogs/list', 'Web\Tutor\BlogController@list');
                        Route::post('blogs/update', 'Web\Tutor\BlogController@update');
                        Route::resource(
                            'blogs',
                            'Web\Tutor\BlogController',
                            [
                                'as' => 'tutor'
                            ]
                        );
                        Route::get(
                            'blogs/{slug}',
                            'Web\Tutor\BlogController@show'
                        )->name('tutor.blogs.detail');
        
                        Route::get(
                            'classes/list',
                            'Web\Tutor\ClassController@list'
                        );
        
                        Route::get(
                            'classes/schedules',
                            'Web\Tutor\ClassController@schedule'
                        )->name('tutor.class.schedule');
        
                        Route::patch(
                            'classes/{class}/publish',
                            'Web\Tutor\ClassController@publish'
                        );
                        Route::get(
                            '/cancel-class/{id}',
                            'Web\Tutor\ClassController@cancelClass'
                        );
        
                        Route::get(
                            '/complete-class/{id}',
                            'Web\Tutor\ClassController@completeClass'
                        );
        
                        Route::get(
                            '/student-list/{id}',
                            'Web\Tutor\ClassController@studentList'
                        )->name('tutor.student.list');
        
                        Route::get(
                            '/student-details/{id}',
                            'Web\RatingController@studentDetails'
                        )->name('tutor.student.details');
        
                        Route::put(
                            '/update-raise-hand-request/{id}',
                            'Web\Tutor\ClassController@updateRaiseHandRequest'
                        );
                        Route::put(
                            '/update-class-room-token/{id}',
                            'Web\Tutor\ClassController@updateClassRoomToken'
                        );
        
                        Route::post(
                            '/add-extra-hour/{class}',
                            'Web\Tutor\ClassController@addExtraHour'
                        )->name('classes.add-extra-hour');
        
                        Route::post(
                            '/class-details/{id}',
                            'Web\Tutor\ClassController@addClassDetail'
                        )->name('tutor.class-details.store');
                        Route::get(
                            '/start/{slug}',
                            'Web\Tutor\ClassController@startClass'
                        )->name('tutor.class.start');
                        Route::resource(
                            'classes',
                            'Web\Tutor\ClassController',
                            [
                                'as' => 'tutor',
                            ]
                        );
                        Route::get(
                            'classes/{slug}',
                            'Web\Tutor\ClassController@show'
                        )->name('tutor.classes.detail');
        
                        Route::resource(
                            'classes.topic',
                            'Web\Tutor\TopicController',
                            [
                                'as' => 'tutor',
                            ]
                        );
                        Route::delete(
                            'sub-topic/{id}',
                            'Web\Tutor\TopicController@deleteSubTopic'
                        )->name('tutor.subTopic.destroy');
        
                        Route::resource(
                            'webinars',
                            'Web\Tutor\WebinarController',
                            [
                                'as' => 'tutor',
                            ]
                        );
                        Route::get(
                            'webinars/{slug}',
                            'Web\Tutor\WebinarController@show'
                        )->name('tutor.webinars.detail');
                        
                        
                        Route::get(
                            'profile/edit',
                            'Web\Tutor\ProfileController@index'
                        )->name('tutor.profile.edit');

                        Route::get(
                            'subscription/purchase',
                            'Web\Tutor\SubscriptionController@purchaseList'
                        )->name('tutor.subscription.purchase');
                        Route::get(
                            '/subscriptions',
                            'Web\Tutor\SubscriptionController@index'
                        )->name('tutor.subscription.index');
                        Route::get(
                            '/subscription/purchase/details/{id}',
                            'Web\Tutor\SubscriptionController@subscriptionDetails'
                        )->name('tutor.subscription.details');
                        Route::get(
                            '/new-subscription-plan/list',
                            'Web\Tutor\SubscriptionController@subscriptionPlanList'
                        )->name('tutor.new-subscription-plan.list');

                        Route::group(
                            ['prefix' => 'payment-method'],
                            function () {
                                Route::get(
                                    '/',
                                    'Web\PaymentMethodController@index'
                                )->name('tutor.payment-method.index');
                                Route::get(
                                    '/list',
                                    'Web\PaymentMethodController@list'
                                )->name('tutor.payment-method.list');
                                Route::post(
                                    '/',
                                    'Web\PaymentMethodController@store'
                                )->name('tutor.payment-method.store');
                                Route::delete(
                                    '/{id}',
                                    'Web\PaymentMethodController@delete'
                                )->name('tutor.payment-method.destroy');
                                Route::post(
                                    '/bank-details',
                                    'Web\PaymentMethodController@saveBankDetail'
                                )->name('tutor.payment-method.bank-details');
                                Route::get(
                                    '/bank-name',
                                    'Web\PaymentMethodController@getBankName'
                                )->name('tutor.payment-method.bank-name');
        
                            }
                        );

                        Route::group(
                            ['prefix' => 'rating'],
                            function () {
                                Route::get(
                                    '/',
                                    'Web\RatingController@index'
                                )->name('tutor.rating.index');
                                Route::get(
                                    '/list',
                                    'Web\RatingController@list'
                                )->name('tutor.rating.list');
                            }
                        );
                        
                           
                        Route::resource(
                            'referral-code',
                            'Web\ReferralCodeController',
                            [
                                'as' => 'tutor',
                            ]
                        );
                        Route::get(
                            'notification',
                            'Web\NotificationController@index'
                        )->name('tutor.notification.index');
                        Route::get(
                            'feedback/{class}',
                            'Web\FeedbackController@index'
                        )->name('tutor.feedback.index');
                        Route::get(
                            'feedback/search/{id}',
                            'Web\FeedbackController@search'
                        )->name('tutor.feedback.search');
                        Route::get(
                            'feedback/student/{id}',
                            'Web\FeedbackController@findStudent'
                        )->name('tutor.feedback.search');
                        Route::post(
                            'feedback/store',
                            'Web\FeedbackController@storeRatingReview'
                        )->name('tutor.feedback.store');
                        Route::get(
                            'feedback/{class}/{receiverId}',
                            'Web\FeedbackController@tutorReceivedFeedback'
                        )->name('tutor.received.feedback.index');
                        Route::group(
                            ['prefix' => 'transactions'],
                            function () {
                                Route::get(
                                    '/',
                                    'Web\TransactionController@index'
                                )->name('tutor.transactions.index');
                                Route::get(
                                    '/list',
                                    'Web\TransactionController@list'
                                )->name('tutor.transactions.list');
                                Route::get(
                                    '/payout-list',
                                    'Web\TransactionController@payoutList'
                                )->name('tutor.transactions.payout-list');
                            }
                        );

                        Route::get(
                            'top-up/purchase',
                            'Web\Tutor\TopUpController@list'
                        );

                        Route::resource(
                            'top-up',
                            'Web\Tutor\TopUpController',
                            [
                                'as' => 'tutor',
                            ]
                        );

                        Route::group(
                            [
                                'prefix' => 'chat'
                            ],
                            function () {
                                Route::get('/', 'Web\Tutor\MessageController@index')
                                    ->name('message-tutor');
                                Route::get('list', 'Web\Tutor\MessageController@list')
                                    ->name('message-tutor-list');
                                Route::get(
                                    '/{uuid?}/{studentId?}',
                                    'Web\Tutor\MessageController@detail'
                                )
                                    ->name('message-tutor-detail');
                            }
                        );
                        
                    }
                );
               

                Route::get(
                    'change-password',
                    'Web\Tutor\ChangePasswordController@index'
                )->name('tutor.change-password.index');
                Route::post(
                    'change-password',
                    'Web\Tutor\ChangePasswordController@update'
                )->name('tutor.change-password.update');

                Route::get(
                    'change-email/verify-otp/{token}',
                    'Web\Tutor\ProfileController@verifyOtpForm'
                )->name('tutor.change-email.verifyOtp.form');
                Route::post(
                    'change-email/verify-otp',
                    'Web\Tutor\ProfileController@verifyOtp'
                )->name('tutor.change-email.verifyOtp');
               
                Route::group(
                    ['prefix' => 'wallet'],
                    function () {
                        Route::get(
                            '/',
                            'Web\WalletController@index'
                        )->name('tutor.wallet.index');
                        Route::get(
                            '/list',
                            'Web\WalletController@list'
                        )->name('tutor.wallet.list');
                        Route::post(
                            '/',
                            'Web\WalletController@addBalance'
                        )->name('tutor.wallet.store');
                        Route::post(
                            '/redeem-points',
                            'Web\WalletController@redeemPoints'
                        )->name('tutor.wallet.redeem');
                    }
                );
            
            }
        );

        Route::get(
            'logout',
            'Auth\Frontend\LoginController@logout'
        )->name('tutor/logout');


         // class request
         Route::get(
            'classrequest/list',
            'Web\Tutor\TutorClassRequestController@tutorClassRequestList'
        )->name('tutor.classrequest.list');

        Route::resource(
            'classrequest',
            'Web\Tutor\TutorClassRequestController',
            [
                'as' => 'tutor',
            ]
        );

         // class request
        
        Route::resource(
            'tutorquote',
            'Web\Tutor\TutorQuoteController',
            [
                'as' => 'tutor',
            ]
        );


    }
);
