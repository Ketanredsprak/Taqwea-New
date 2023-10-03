<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => ['web', ]
    ],
    function () {
        Route::group(
            [
                'middleware' => ['guest:web']
            ],
            function () {
                Route::get('/', 'Web\HomeController@index')->name('home');
                Route::get(
                    '/home/classes',
                    'Web\HomeController@classList'
                )->name('home.classes');

                Route::post(
                    'language',
                    'Web\HomeController@setLanguage'
                )->name('setLanguage');

                Route::get(
                    'sign-up/complete',
                    'Auth\Frontend\RegisterController@completeSignUpForm'
                )->name('sign-up/complete/form');
                Route::post(
                    'sign-up/complete',
                    'Auth\Frontend\RegisterController@completeSignUp'
                )->name('sign-up/complete');

                Route::get(
                    'categories/{category}/grades',
                    'Web\CategoryController@grades'
                );
                Route::get(
                    '/categories/{category}/childrens',
                    'Web\CategoryController@childrens'
                );
                Route::get('subjects', 'Web\CategoryController@subjects');

                Route::get(
                    'contact-us',
                    'Web\HomeController@contactUs'
                )->name('contact-us');
                Route::post(
                    'contact-submit',
                    'Web\HomeController@contactSubmit'
                )->name('contact-submit');

                Route::group(
                    [
                        'prefix' => 'faq'
                    ],
                    function () {
                        Route::get('/', 'Web\CmsController@faq')->name('faq');
                        Route::get(
                            'list',
                            'Web\CmsController@faqList'
                        )->name('faq/list');
                    }
                );

                Route::group(
                    [
                        'prefix' => 'blogs'
                    ],
                    function () {
                        Route::get('/', 'Web\BlogController@index')->name('blogs');
                        Route::get(
                            'list',
                            'Web\BlogController@blogList'
                        )->name('blog/list');
                        Route::get(
                            '/{blog}',
                            'Web\BlogController@show'
                        )->name('blog/show');

                        Route::get(
                            '/download/{blog}',
                            'Web\BlogController@download'
                        )->name('blog/download');
                    }
                );

                Route::group(
                    [
                        'prefix' => 'webinars'
                    ],
                    function () {
                        Route::get(
                            '/',
                            'Web\WebinarController@index'
                        )->name('webinars');
                        Route::get(
                            '/{class}',
                            'Web\WebinarController@show'
                        )->name('webinars/show');
                    }
                );

                Route::group(
                    [
                        'prefix' => 'classes'
                    ],
                    function () {
                        Route::get(
                            '/',
                            'Web\ClassController@index'
                        )->name('classes');
                        Route::get(
                            'list',
                            'Web\ClassController@list'
                        )->name('classes/list');

                        Route::get(
                            '/schedules',
                            'Web\ClassController@classSchedule'
                        )->name('classes.schedules');

                        Route::get(
                            '/{class}',
                            'Web\ClassController@show'
                        )->name('classes/show');
                        Route::get(
                            '/schedules/list',
                            'Web\ClassController@scheduleList'
                        );
                    }
                );
                Route::post(
                    'send-otp',
                    'Auth\Frontend\VerifyOtpController@sendOtp'
                );

                Route::get(
                    'logout',
                    'Auth\Frontend\LoginController@logout'
                )->name('student/logout');

                Route::group(
                    [
                        'prefix' => 'tutors'
                    ],
                    function () {
                        Route::get(
                            '/',
                            'Web\TutorController@index'
                        )->name('tutors');
                        Route::get(
                            'list',
                            'Web\TutorController@list'
                        )->name('tutors.list');
                        Route::get(
                            '/{tutor}',
                            'Web\TutorController@show'
                        )->name('featured.tutors.show');
                    }
                );
            }
        );

        Route::group(
            [
                'middleware' => 'CheckLogin:web'
            ],
            function () {
                Route::get(
                    'sign-up',
                    'Auth\Frontend\RegisterController@index'
                )->name('show/signup');
                Route::post(
                    'sign-up',
                    'Auth\Frontend\RegisterController@store'
                )->name('signup');
                Route::get(
                    'login',
                    'Auth\Frontend\LoginController@showLoginForm'
                )->name('show/login');
                Route::post(
                    'login',
                    'Auth\Frontend\LoginController@login'
                )->name('login');
                Route::get(
                    'verify-otp/{token}',
                    'Auth\Frontend\VerifyOtpController@index'
                )->name('verify-otp');
                Route::post(
                    'verify-otp',
                    'Auth\Frontend\VerifyOtpController@store'
                );
                Route::get(
                    'forgot-password',
                    'Auth\Frontend\ForgotPasswordController@index'
                )->name('frontend/forgot-password');
                Route::post(
                    'forgot-password/send-otp',
                    'Auth\Frontend\ForgotPasswordController@sendOtp'
                )->name('frontend/forgot-password/send-otp');
                Route::get(
                    'forgot-password/verify-otp/{token}',
                    'Auth\Frontend\ForgotPasswordController@verifyOtpForm'
                )->name('frontend/forgot-password/verify-otp');
                Route::get(
                    'forgot-password/create-password/{token}',
                    'Auth\Frontend\ForgotPasswordController@createPasswordForm'
                )->name('forgot-password/create-password');
                Route::post(
                    'forgot-password/create-password',
                    'Auth\Frontend\ForgotPasswordController@createPassword'
                );
            }
        );

        Route::group(
            [
                'middleware' => [
                    'auth:web'
                ]
            ],
            function () {
                Route::get(
                    'users/{user}',
                    'Web\ShowProfile'
                )->name('frontend.user-profile');
                Route::patch(
                    'users/{user}/update-token',
                    'Web\UserController@updateToken'
                )->name('frontend.user-profile');

                Route::group(
                    ['prefix' => 'checkout'],
                    function () {
                        Route::get(
                            '/',
                            'Web\CheckoutController@index'
                        )->name('student.checkout.index');
                        Route::post(
                            '/',
                            'Web\CheckoutController@store'
                        )->name('student.checkout.store');

                        Route::get(
                            '/pay-now/{checkoutId}',
                            'Web\CheckoutController@payNow'
                        );

                        Route::get(
                            '/success',
                            'Web\CheckoutController@paymentSuccess'
                        )->name('checkout.returnUrl');
                    }
                );

                Route::get(
                    '/payment-method',
                    'Web\PaymentMethodController@generateCheckoutId'
                )->name('payment.method.checkout.id');

                Route::get(
                    '/payment-method/return-url',
                    'Web\PaymentMethodController@paymentReturnUrl'
                );

                Route::get(
                    '/payment-method/{checkoutId}',
                    'Web\PaymentMethodController@saveCardForm'
                )->name('payment.method.checkout.saveCardForm');
               
            }
        );

        Route::group(
            ['prefix' => 'admin'],
            function () {
                Route::group(
                    ['middleware' => 'CheckLogin:web'],
                    function () {
                        Route::get(
                            '/',
                            'Auth\LoginController@showLoginForm'
                        )->name('admin/showLoginPage');
                        Route::get(
                            '/login',
                            'Auth\LoginController@showLoginForm'
                        )->name('admin/showLoginPage');
                        Route::post(
                            '/submit-login',
                            'Auth\LoginController@login'
                        )->name('admin/submitLogin');
                        Route::get(
                            '/forgot-password',
                            'Auth\ForgotPasswordController@showForgotPasswordForm'
                        );
                        Route::post(
                            '/post-forgot-password',
                            'Auth\ForgotPasswordController@submitForgotPassword'
                        )->name('forgot-password');
                        Route::get(
                            '/reset-password',
                            'Auth\ForgotPasswordController@resetPassword'
                        );
                        Route::post(
                            '/resend-otp',
                            'Auth\ForgotPasswordController@resendOtp'
                        );
                        Route::post(
                            '/post-reset-password',
                            'Auth\ForgotPasswordController@postResetPassword'
                        );
                        Route::get(
                            '/otp-verification',
                            function () {
                                return view('admin.auth.otp-verification');
                            }
                        );
                        Route::post(
                            '/opt-verification',
                            'Auth\LoginController@otpVerification'
                        );
                        Route::post(
                            '/resend-otp-verification',
                            'Auth\LoginController@resendOtpVerification'
                        );
                    }
                );

                Route::group(
                    ['middleware' => 'admin:web'],
                    function () {
                        Route::get(
                            '/logout',
                            'Auth\LoginController@logout'
                        )->name('admin-logout');
                        Route::get(
                            '/dashboard',
                            'Web\Admin\DashboardController@index'
                        )->name('adminDashboard');
                        Route::get(
                            '/profile',
                            'Web\Admin\ProfileController@editProfile'
                        )->name('tutor/profile');
                        Route::post(
                            '/update-profile',
                            'Web\Admin\ProfileController@updateProfile'
                        );
                        Route::post(
                            '/change-password',
                            'Web\Admin\ProfileController@changePassword'
                        );
                        Route::post(
                            '/upload-profile',
                            'Web\Admin\ProfileController@uploadProfile'
                        );
                        Route::get(
                            '/setting',
                            'Web\Admin\SettingController@getSetting'
                        );
                        Route::post(
                            '/setting-post',
                            'Web\Admin\SettingController@storeSetting'
                        );
                        Route::resource(
                            '/tutors',
                            'Web\Admin\TutorController'
                        );
                        Route::get(
                            '/tutor/list',
                            'Web\Admin\TutorController@tutorList'
                        );
                        Route::patch(
                            '/tutors/{tutor}/{status}',
                            'Web\Admin\TutorController@approveOrReject'
                        );
                        Route::patch(
                            '/verificationStatus/{tutor}/{status}',
                            'Web\Admin\TutorController@verificationStatus'
                        );
                        Route::post(
                            '/changePassword',
                            'Web\Admin\UserController@changePassword'
                        )->name('tutor');
                        Route::put(
                            '/changeStatus',
                            'Web\Admin\UserController@changeStatus'
                        );
                        Route::resource(
                            '/students',
                            'Web\Admin\StudentController'
                        );
                        Route::get(
                            'student/list',
                            'Web\Admin\StudentController@studentList'
                        );
                        Route::get(
                            '/categories/{category}/childrens',
                            'Web\Admin\CategoryController@childrens'
                        );

                        Route::resource(
                            '/categories',
                            'Web\Admin\CategoryController'
                        );

                        Route::resource(
                            '/category-subjects',
                            'Web\Admin\CategorySubjectController'
                        );

                        Route::resource(
                            '/faqs',
                            'Web\Admin\FaqController'
                        );
                        Route::get(
                            'faq-filter',
                            'Web\Admin\FaqController@filter'
                        );

                        Route::get('faq-filter', 'Web\Admin\FaqController@filter');

                        Route::get('classes/list', 'Web\Admin\ClassController@list');
                        Route::get(
                            'webinars',
                            'Web\Admin\ClassController@webinar'
                        );
                        Route::get(
                            'webinars/{class}',
                            'Web\Admin\ClassController@show'
                        );
                        Route::get(
                            'bookings/classes',
                            'Web\Admin\ClassController@bookings'
                        )->name('admin.booking.class');
                        Route::get(
                            'booking/classes/{id}',
                            'Web\Admin\ClassController@showBookingClasses'
                        )->name('admin.bookings-class');
                        Route::get(
                            'booking/class/list/{id}',
                            'Web\Admin\ClassController@bookingClassList'
                        );
                        Route::get(
                            'bookings/webinars',
                            'Web\Admin\ClassController@bookingsWebinar'
                        )->name('admin.booking.webinar');

                        Route::get(
                            'bookings/list',
                            'Web\Admin\ClassController@classBookingList'
                        );
                        Route::resource(
                            '/classes',
                            'Web\Admin\ClassController'
                        );

                        Route::get('blogs/list', 'Web\Admin\BlogController@list');

                        Route::get(
                            'purchased-blogs',
                            'Web\Admin\BlogController@purchased'
                        )->name('admin.blog.purchase');

                        Route::get(
                            'purchased-blogs/{id}',
                            'Web\Admin\BlogController@purchasedBlogDetail'
                        )->name('admin.blog.purchase-view');

                        Route::get(
                            'blogs/purchase/list',
                            'Web\Admin\BlogController@purchaseList'
                        )->name('admin.blog.purchase.list');

                        Route::resource(
                            '/blogs',
                            'Web\Admin\BlogController'
                        );

                        Route::get(
                            '/commission',
                            'Web\Admin\SettingController@index'
                        );

                        Route::post(
                            '/commission-post',
                            'Web\Admin\SettingController@store'
                        );
                        Route::get(
                            'help-support',
                            'Web\Admin\SupportController@index'
                        )->name('help-support');

                        Route::get(
                            'help-support/list',
                            'Web\Admin\SupportController@supportList'
                        );
                        Route::get(
                            'read/{id}',
                            'Web\Admin\SupportController@showEmailMessage'
                        );
                        Route::post(
                            'support-email-reply',
                            'Web\Admin\SupportController@emailReply'
                        );

                        Route::get('cms/{id}', 'Web\Admin\CmsController@index');
                        Route::post(
                            'cms-update',
                            'Web\Admin\CmsController@cmsUpdate'
                        )->name('cms.update');

                        Route::get(
                            'subjects/list',
                            'Web\Admin\SubjectController@subjectList'
                        );
                        Route::resource(
                            '/subjects',
                            'Web\Admin\SubjectController'
                        );
                        Route::resource(
                            '/testimonials',
                            'Web\Admin\TestimonialController'
                        );
                        Route::get(
                            'testimonial/list',
                            'Web\Admin\TestimonialController@testimonialList'
                        );
                        Route::get(
                            'transactions-history',
                            'Web\Admin\TransactionController@transactionHistory'
                        )->name('transaction.history');
                        Route::get(
                            'transaction-history/list',
                            'Web\Admin\TransactionController@transactionHistoryList'
                        );
                        Route::post(
                            'transaction-history/export',
                            'Web\Admin\TransactionController@transactionExportCsv'
                        )->name('transaction-export');
                        Route::get(
                            'student-report',
                            'Web\Admin\ReportController@studentReport'
                        );
                        Route::get(
                            'report/list',
                            'Web\Admin\ReportController@reportList'
                        );
                        Route::post(
                            'student/report/export',
                            'Web\Admin\ReportController@studentExportCsv'
                        )->name('student.export');
                        Route::get(
                            'tutor-report',
                            'Web\Admin\ReportController@tutorReport'
                        );
                        Route::post(
                            'tutor/report/export',
                            'Web\Admin\ReportController@tutorExportCsv'
                        )->name('tutor.export');
                        Route::get(
                            'class-report',
                            'Web\Admin\ReportController@classReport'
                        );
                        Route::get(
                            'class-report/list',
                            'Web\Admin\ReportController@classReportList'
                        );
                        Route::post(
                            'class/report/export',
                            'Web\Admin\ReportController@classExportCsv'
                        )->name('class.export');
                        Route::get(
                            'blog-report',
                            'Web\Admin\ReportController@blogReport'
                        );
                        Route::get(
                            'blog-report/list',
                            'Web\Admin\ReportController@blogReportList'
                        );
                        Route::post(
                            'blog/report/export',
                            'Web\Admin\ReportController@blogExportCsv'
                        )->name('blog.export');
                        Route::get(
                            'webinar-report',
                            'Web\Admin\ReportController@webinarReport'
                        );
                        Route::get(
                            'webinar-report/list',
                            'Web\Admin\ReportController@webinarReportList'
                        );
                        Route::post(
                            'webinar/report/export',
                            'Web\Admin\ReportController@webinarExportCsv'
                        )->name('webinar.export');
                        Route::get(
                            'revenue-report',
                            'Web\Admin\ReportController@revenueReport'
                        );
                        Route::get(
                            'revenue-report/list',
                            'Web\Admin\ReportController@revenueReportList'
                        );
                        Route::post(
                            'revenue/report/export',
                            'Web\Admin\ReportController@revenueExportCsv'
                        )->name('revenue.export');
                        Route::resource(
                            '/subscriptions',
                            'Web\Admin\SubscriptionController'
                        );
                        Route::get(
                            '/subscription/list',
                            'Web\Admin\SubscriptionController@subscriptionList'
                        );
                        Route::get(
                            'running-subscription',
                            'Web\Admin\SubscriptionController@runningSubscription'
                        )->name('admin.running-subscription');
                        Route::get(
                            'running-subscription/list',
                            'Web\Admin\SubscriptionController@runningSubscriptionList'
                        );
                        Route::get(
                            'top-up',
                            'Web\Admin\SettingController@getTopUp'
                        );
                        Route::post(
                            'top-up',
                            'Web\Admin\SettingController@updateTopUp'
                        );
                        Route::get(
                            'dashboard-chart',
                            'Web\Admin\DashboardController@dashboardChart'
                        );
                        Route::get(
                            'notifications',
                            'Web\Admin\NotificationController@index'
                        );
                        Route::get(
                            'all_notifications_read',
                            'Web\Admin\NotificationController@markAllAsRead'
                        );
                        Route::get(
                            'tutors/{tutorId}/schedules',
                            'Web\Admin\TutorController@schedule'
                        );
                        Route::get(
                            'tutor/{tutorId}/schedule-list',
                            'Web\Admin\TutorController@scheduleList'
                        );
                        Route::get(
                            '/config-clear',
                            function () {
                                Artisan::call('cache:clear');
                                Artisan::call('config:clear');
                                Artisan::call('view:clear');
                                Artisan::call('config:cache');

                                return config('jwt.ttl');
                            }
                        );
                        Route::get(
                            '/maintenance-mode/{mode}',
                            function ($mode) {
                                Artisan::call($mode);
                                if ($mode == 'up') {
                                    return 'Website is Up.';
                                }
                                return 'In Maintenance mode.';
                            }
                        )->name('maintenance');
                        Route::get(
                            '/tutor/download-education-document/{id}',
                            'Web\Admin\TutorController@downloadEducationDoc'
                        );
                        Route::get(
                            '/tutor/download-experience-document/{id}',
                            'Web\Admin\TutorController@downloadExperienceDoc'
                        );
                        Route::put('/status', 'Web\Admin\BankController@updateStatus');
                        Route::resource('banks', 'Web\Admin\BankController');
                        Route::resource('demo','Web\Admin\DemoController');
                        Route::get('demo-list','Web\Admin\DemoController@demoList');
                    }
                );
            }
        );
        Route::get(
            '/clear',
            function () {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('config:cache');
                Artisan::call('view:clear');

                return 'Cleared!';
            }
        );
    }
);

Route::get('set-timezone', 'Web\HomeController@setTimezone');

Route::get(
    'login/{provider}',
    'Auth\Frontend\LoginController@redirectToProvider'
);
Route::any(
    'login/{provider}/callback',
    'Auth\Frontend\LoginController@handleProviderCallback'
);

Route::get(
    '/search',
    'Web\GlobalSearchController@index'
);
Route::get('{slug}', 'Web\CmsController@index');
Route::post('hyper-pay-notification', 'Web\WebHookController@index');
Route::post('hyper-payout-notification', 'Web\WebHookController@webhookSplit');

Route::group(
    ['prefix' => 'checkout'],
    function () {
        Route::get(
            '/pay-now/{checkoutId}',
            'Web\CheckoutController@payNow'
        )->name('checkout.payNow');

        Route::get(
            '/success',
            'Web\CheckoutController@paymentSuccess'
        )->name('checkout.returnUrl');
    }
);

