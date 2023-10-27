<?php

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register student routes for your application.
|
*/

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [
            'web',
            'student:web'
        ]
    ],
    function () {
        Route::get('/', 'Web\Student\DashboardController@index');
        Route::get(
            'dashboard',
            'Web\Student\DashboardController@index'
        )->name('student/dashboard');

        Route::get(
            'dashboard/classes',
            'Web\Student\DashboardController@classes'
        )->name('student.dashboard.classes');

        Route::get(
            'logout',
            'Auth\Frontend\LoginController@logout'
        )->name('student/logout');
        Route::get(
            'classes/list',
            'Web\Student\ClassController@list'
        );



        Route::resource(
            'classes',
            'Web\Student\ClassController',
            [
                'as' => 'student',
            ]
        );
        Route::resource(
            'webinars',
            'Web\Student\WebinarController',
            [
                'as' => 'student',
            ]
        );
        Route::get(
            'join-now/{slug}',
            'Web\Student\ClassController@joinNow'
        )->name('student.join');
        Route::put(
            'update-extra-hour-request',
            'Web\Student\ClassController@updateExtraHourRequest'
        );
        Route::get(
            'change-password',
            'Web\Student\ChangePasswordController@index'
        )->name('student.change-password.index');
        Route::post(
            'change-password',
            'Web\Student\ChangePasswordController@update'
        )->name('student.change-password.update');
        Route::get(
            'profile/edit',
            'Web\Student\ProfileController@index'
        )->name('student.profile.edit');
        Route::post(
            '/{id}/update-profile',
            'Web\Student\ProfileController@update'
        )->name('student.profile.update');

        Route::get(
            '/profile',
            'Web\Student\ProfileController@getDetails'
        );

        Route::group(
            ['prefix' => 'wallet'],
            function () {
                Route::get(
                    '/',
                    'Web\WalletController@index'
                )->name('student.wallet.index');
                Route::get(
                    '/list',
                    'Web\WalletController@list'
                )->name('student.wallet.list');
                Route::post(
                    '/',
                    'Web\WalletController@addBalance'
                )->name('student.wallet.store');
                Route::post(
                    '/redeem-points',
                    'Web\WalletController@redeemPoints'
                )->name('student.wallet.redeem');
            }
        );



        Route::get(
            '/cancel-booking/{id}',
            'Web\Student\ClassController@cancelBooking'
        );

        Route::get(
            '/complete-booking/{id}',
            'Web\Student\ClassController@completeBooking'
        );

        Route::post(
            '/raise-hand',
            'Web\Student\ClassController@raiseHand'
        );

        Route::put(
            '/update-raise-hand-request/{id}',
            'Web\Student\ClassController@updateRaiseHandRequest'
        );

        Route::get(
            '/blogs',
            'Web\Student\BlogController@index'
        )->name('student.blog');
        Route::get(
            '/blogs/list',
            'Web\Student\BlogController@list'
        )->name('student.blog.list');

        Route::group(
            ['prefix' => 'transactions'],
            function () {
                Route::get(
                    '/',
                    'Web\TransactionController@index'
                )->name('student.transactions.index');
                Route::get(
                    '/list',
                    'Web\TransactionController@list'
                )->name('student.transactions.list');
            }
        );

        Route::resource(
            'carts',
            'Web\Student\CartController',
            [
                'as' => 'student',
            ]
        );

        // class request

        
        Route::get(
            'classrequest/list',
            'Web\Student\ClassRequestController@classRequestList'
        )->name('student.classrequest.list');
        
        Route::get(
            'test',
            'Web\Student\ClassRequestController@checkfunction'
        )->name('student.test');



        Route::get('getrequest/{id}', 'Web\Student\ClassRequestController@gettutorrequestget')->name('student.classrequest.getrequest');
        Route::get('cancelrequest/{id}', 'Web\Student\ClassRequestController@cancelrequest')->name('student.classrequest.cancelrequest');
        Route::get('acceptrequest/{id}', 'Web\Student\ClassRequestController@acceptrequest')->name('student.classrequest.acceptrequest');
        Route::get('rejectrequest/{id}', 'Web\Student\ClassRequestController@rejectrequest')->name('student.classrequest.rejectrequest');
        Route::get('showtutordetail/{id}', 'Web\Student\ClassRequestController@showtutordetail')->name('student.classrequest.showtutordetail');
        

        Route::resource(
            'classrequest',
            'Web\Student\ClassRequestController',
            [
                'as' => 'student',
            ]
        );

       
    


        Route::delete('carts/{id}/{item_id}', 'Web\Student\CartController@destroy');
        Route::group(
            ['prefix' => 'rating'],
            function () {
                Route::get(
                    '/',
                    'Web\RatingController@index'
                )->name('student.rating.index');
                Route::get(
                    '/list',
                    'Web\RatingController@list'
                )->name('student.rating.list');
            }
        );
        Route::group(
            ['prefix' => 'payment-method'],
            function () {
                Route::get(
                    '/',
                    'Web\PaymentMethodController@index'
                )->name('student.payment-method.index');
                Route::get(
                    '/list',
                    'Web\PaymentMethodController@list'
                )->name('student.payment-method.list');
                Route::post(
                    '/',
                    'Web\PaymentMethodController@store'
                )->name('student.payment-method.store');
                Route::delete(
                    '/{id}',
                    'Web\PaymentMethodController@delete'
                )->name('student.payment-method.destroy');
            }
        );
        Route::resource(
            'referral-code',
            'Web\ReferralCodeController',
            [
                'as' => 'student',
            ]
        );
        Route::get(
            'notification',
            'Web\NotificationController@index'
        )->name('student.notification.index');
        
        Route::get(
            'send-test-notification',
            'Web\NotificationController@sendNotification'
        );

        Route::group(
            [
                'prefix' => 'chat'
            ],
            function () {
                Route::get('/', 'Web\Student\MessageController@index')
                ->name('message-student');
                Route::get('list', 'Web\Student\MessageController@list')
                ->name('message-student-list');
                Route::get('/{uuid?}', 'Web\Student\MessageController@detail')
                ->name('message-student-detail');
            }
        );
        Route::post(
            'feedback',
            'Web\FeedbackController@storeRatingReview'
        )->name('student.feedback.store');
        Route::get(
            'feedback/{class}',
            'Web\FeedbackController@studentFeedback'
        )->name('student.feedback.index');
        Route::post(
            'feedback/dispute-reason',
            'Web\FeedbackController@postDisputeReason'
        )->name('student.feedback.dispute-reason');
        
    }
);
