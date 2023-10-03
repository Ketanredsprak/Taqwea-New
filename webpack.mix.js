const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins: [
        new WebpackShellPlugin({ onBuildStart: ['php artisan lang:js --quiet'], onBuildEnd: [] })
    ]
});
mix.config.fileLoaderDirs.fonts = 'assets/fonts';
mix.disableNotifications();
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/admin/taqwea.scss', 'public/assets/css/admin')
    .sass('resources/sass/frontend/frontend.scss', 'public/assets/css/frontend/frontend.css')
    .sass('resources/sass/frontend/common.scss', 'public/assets/css/frontend/common.css')
    .sass('resources/sass/frontend/auth.scss', 'public/assets/css/frontend/auth.css')
    .options({
        processCssUrls: false
    });

mix.copyDirectory('resources/fonts', 'public/assets/fonts');
mix.styles([
    'resources/css/admin/icomoon.css',
    'resources/css/admin/editors/summernote.css',
    'resources/css/admin/jquery.timepicker.css',
    'resources/css/admin/tinymce.css',
    'resources/css/frontend/cropper.min.css',
], 'public/assets/css/admin/admin-app.css');

// Create css for frontend
mix.styles([
    'resources/css/frontend/bootstrap.min.css',
    'resources/css/frontend/select2.min.css',
    'resources/css/frontend/slick-theme.css',
    'resources/css/frontend/slick.css',
    'resources/css/frontend/cropper.min.css',
    'resources/css/frontend/sweetalert2.min.css',
    'resources/css/calendar/ummalqura.calendars.picker.css',
], 'public/assets/css/frontend/frontend-app.css');

mix.js('resources/js/admin/app.js', 'public/assets/js/admin/app.js');
mix.scripts([
    'resources/js/bootstrap.bundle.min.js',
    'resources/js/admin/dataTables.bootstrap4.min.js',
    'resources/js/admin/nioapp.min.js',
    'resources/js/admin/simplebar.js',
    'resources/js/jquery.timepicker.js',
    'resources/js/admin/common.js',
    'resources/js/scripts.js',
    'resources/js/editors.js',
    'resources/js/sweetalert2.min.js',
    'resources/js/select2.full.min.js',
    'resources/js/fullcalendar.min.js',
    'resources/js/bootstrap-datepicker.min.js',
    'public/vendor/jsvalidation/js/jsvalidation.min.js',
    'resources/js/frontend/cropper.min.js',
], 'public/assets/js/admin/admin-app.js');

// Create js file for frontend
mix.js('resources/js/frontend/app.js', 'public/assets/js/frontend/app.js');
mix.scripts([
    'resources/js/admin/dataTables.bootstrap4.min.js',
    'resources/js/jquery.min.js',
    'resources/js/bootstrap.bundle.min.js',
    'resources/js/sweetalert2.min.js',
    'resources/js/select2.min.js',
    'resources/js/frontend/progressively.min.js',
    'resources/js/frontend/slick.min.js',
    'resources/js/frontend/common.js',
    'resources/js/frontend/cropper.min.js',
    'public/vendor/jsvalidation/js/jsvalidation.min.js',
    'resources/js/frontend/jquery.countdown.js',
    'resources/js/calendar/jquery.calendars.js',
    'resources/js/calendar/jquery.plugin.js',
    'resources/js/calendar/jquery.calendars.plus.js',
    'resources/js/calendar/jquery.calendars.picker.js',
    'resources/js/calendar/jquery.calendars.picker-ar.js',
    'resources/js/calendar/jquery.calendars.ummalqura.js',
    'resources/js/calendar/jquery.calendars.ummalqura-ar.js',
    'resources/js/calendar/calendar-convert.js',
], 'public/assets/js/frontend/frontend-app.js');

mix.scripts([
    'resources/js/calendar/jquery.calendars.js',
    'resources/js/calendar/jquery.plugin.js',
    'resources/js/calendar/jquery.calendars.plus.js',
    'resources/js/calendar/jquery.calendars.picker.js',
    'resources/js/calendar/jquery.calendars.picker-ar.js',
    'resources/js/calendar/jquery.calendars.ummalqura.js',
    'resources/js/calendar/jquery.calendars.ummalqura-ar.js',
    'resources/js/calendar/calendar-convert.js',
], 'public/assets/js/frontend/calendar.js');

mix.js([
        'resources/js/admin/auth/login.js'
    ], 'public/assets/js/admin/auth/login.js')
    .js([
        'resources/js/admin/profile/profile.js'
    ], 'public/assets/js/admin/profile/profile.js')
    .js([
        'resources/js/admin/auth/forget-password.js'
    ], 'public/assets/js/admin/auth/forget-password.js')
    .js([
        'resources/js/admin/auth/reset-password.js'
    ], 'public/assets/js/admin/auth/reset-password.js')
    .js([
        'resources/js/admin/faqs/faq.js'
    ], 'public/assets/js/admin/faqs/faq.js')
    .js([
        'resources/js/admin/students/index.js'
    ], 'public/assets/js/admin/students/index.js')
    .js([
        'resources/js/admin/categories/index.js'
    ], 'public/assets/js/admin/categories/index.js')
    .js([
        'resources/js/admin/commission/index.js'
    ], 'public/assets/js/admin/commission/index.js')
    .js([
        'resources/js/admin/classes/class.js'
    ], 'public/assets/js/admin/classes/class.js')
    .js([
        'resources/js/admin/classes/webinar.js'
    ], 'public/assets/js/admin/classes/webinar.js')
    .js([
        'resources/js/admin/classes/bookings.js'
    ], 'public/assets/js/admin/classes/bookings.js')
    .js([
        'resources/js/admin/tutors/index.js'
    ], 'public/assets/js/admin/tutors/index.js')
    .js([
        'resources/js/admin/cms/cms.js'
    ], 'public/assets/js/admin/cms/cms.js')
    .js([
        'resources/js/admin/support/support.js'
    ], 'public/assets/js/admin/support/support.js')
    .js([
        'resources/js/admin/auth/otp-verification.js'
    ], 'public/assets/js/admin/auth/otp-verification.js')
    .js([
        'resources/js/admin/subjects/index.js'
    ], 'public/assets/js/admin/subjects/index.js')
    .js([
        'resources/js/admin/tutors/view-tutor.js'
    ], 'public/assets/js/admin/tutors/view-tutor.js')
    .js([
        'resources/js/admin/testimonial/index.js'
    ], 'public/assets/js/admin/testimonial/index.js')
    .js([
        'resources/js/admin/users/change-password.js'
    ], 'public/assets/js/admin/users/change-password.js')
    .js([
        'resources/js/admin/blogs/index.js'
    ], 'public/assets/js/admin/blogs/index.js')
    .js([
        'resources/js/admin/settings/edit-setting.js'
    ], 'public/assets/js/admin/settings/edit-setting.js')
    .js([
        'resources/js/admin/payment-history/transactions-history.js'
    ], 'public/assets/js/admin/payment-history/transactions-history.js')
    .js([
        'resources/js/admin/reports/student-report.js'
    ], 'public/assets/js/admin/reports/student-report.js')
    .js([
        'resources/js/admin/reports/tutor-report.js'
    ], 'public/assets/js/admin/reports/tutor-report.js')
    .js([
        'resources/js/admin/reports/class-report.js'
    ], 'public/assets/js/admin/reports/class-report.js')
    .js([
        'resources/js/admin/reports/revenue-report.js'
    ], 'public/assets/js/admin/reports/revenue-report.js')
    .js([
        'resources/js/admin/blogs/purchase.js'
    ], 'public/assets/js/admin/blogs/purchase.js')
    .js([
        'resources/js/admin/subscription/index.js'
    ], 'public/assets/js/admin/subscription/index.js')
    .js([
        'resources/js/admin/classes/booking-class.js'
    ], 'public/assets/js/admin/classes/booking-class.js')
    .js([
        'resources/js/admin/subscription/running-subscription.js'
    ], 'public/assets/js/admin/subscription/running-subscription.js')
    .js([
        'resources/js/admin/reports/blog-report.js'
    ], 'public/assets/js/admin/reports/blog-report.js')
    .js([
        'resources/js/admin/reports/webinar-report.js'
    ], 'public/assets/js/admin/reports/webinar-report.js')
    .js([
        'resources/js/admin/dashboard/dashboard.js'
    ], 'public/assets/js/admin/dashboard/dashboard.js')
    .js([
        'resources/js/admin/bankDetails.js'
    ], 'public/assets/js/admin/bankDetails.js');


mix.js([
        'resources/js/frontend/image-cropper.js'
    ], 'public/assets/js/frontend/image-cropper.js')
    .js([
        'resources/js/frontend/home/home.js'
    ], 'public/assets/js/frontend/home/home.js')
    .js([
        'resources/js/frontend/auth/signup.js'
    ], 'public/assets/js/frontend/auth/signup.js')
    .js([
        'resources/js/frontend/auth/login.js'
    ], 'public/assets/js/frontend/auth/login.js')
    .js([
        'resources/js/frontend/fcm-token.js'
    ], 'public/assets/js/frontend/fcm-token.js')
    .js([
        'resources/js/frontend/auth/verify-otp.js'
    ], 'public/assets/js/frontend/auth/verify-otp.js')
    .js([
        'resources/js/frontend/auth/complete-signup.js'
    ], 'public/assets/js/frontend/auth/complete-signup.js')
    .js([
        'resources/js/frontend/auth/forgot-password.js'
    ], 'public/assets/js/frontend/auth/forgot-password.js')
    .js([
        'resources/js/frontend/tutor/complete-profile.js'
    ], 'public/assets/js/frontend/tutor/complete-profile.js')
    .js([
        'resources/js/frontend/tutor/education.js'
    ], 'public/assets/js/frontend/tutor/education.js')
    .js([
        'resources/js/frontend/tutor/certificate.js'
    ], 'public/assets/js/frontend/tutor/certificate.js')
    .js([
        'resources/js/frontend/cms/faq.js'
    ], 'public/assets/js/frontend/cms/faq.js')
    .js([
        'resources/js/frontend/blog.js'
    ], 'public/assets/js/frontend/blog.js')
    .js([
        'resources/js/frontend/tutor.js'
    ], 'public/assets/js/frontend/tutor.js')
    .js([
        'resources/js/frontend/blog-detail.js'
    ], 'public/assets/js/frontend/blog-detail.js')
    .js([
        'resources/js/frontend/class.js'
    ], 'public/assets/js/frontend/class.js')
    .js([
        'resources/js/frontend/tutor/dashboard.js'
    ], 'public/assets/js/frontend/tutor/dashboard.js')
    .js([
        'resources/js/frontend/student/dashboard.js'
    ], 'public/assets/js/frontend/student/dashboard.js')
    .js([
        'resources/js/frontend/class-detail.js'
    ], 'public/assets/js/frontend/class-detail.js')
    .js([
        'resources/js/frontend/tutor/class.js'
    ], 'public/assets/js/frontend/tutor/class.js')
    .js([
        'resources/js/frontend/tutor/topic.js'
    ], 'public/assets/js/frontend/tutor/topic.js')
    .js([
        'resources/js/frontend/tutor/blog.js'
    ], 'public/assets/js/frontend/tutor/blog.js')
    .js([
        'resources/js/frontend/tutor/class-list.js'
    ], 'public/assets/js/frontend/tutor/class-list.js')
    .js([
        'resources/js/frontend/tutor/change-password.js'
    ], 'public/assets/js/frontend/tutor/change-password.js')
    .js([
        'resources/js/frontend/tutor/verification-pending.js'
    ], 'public/assets/js/frontend/tutor/verification-pending.js')
    .js([
        'resources/js/frontend/tutor/verify-otp.js'
    ], 'public/assets/js/frontend/tutor/verify-otp.js')
    .js([
        'resources/js/frontend/wallet.js'
    ], 'public/assets/js/frontend/wallet.js')
    .js([
        'resources/js/frontend/student/join-now.js'
    ], 'public/assets/js/frontend/student/join-now.js')
    .js([
        'resources/js/frontend/contact-us/index.js'
    ], 'public/assets/js/frontend/contact-us/index.js')
    .js([
        'resources/js/frontend/tutor/video-call.js'
    ], 'public/assets/js/frontend/tutor/video-call.js')
    .js([
        'resources/js/frontend/booking-operations.js'
    ], 'public/assets/js/frontend/booking-operations.js')
    .js([
        'resources/js/frontend/student/class.js'
    ], 'public/assets/js/frontend/student/class.js')
    .js([
        'resources/js/frontend/student/change-password.js'
    ], 'public/assets/js/frontend/student/change-password.js')
    .js([
        'resources/js/frontend/student/profile.js'
    ], 'public/assets/js/frontend/student/profile.js')
    .js([
        'resources/js/frontend/student/checkout.js'
    ], 'public/assets/js/frontend/student/checkout.js')
    .js([
        'resources/js/frontend/student/blog.js'
    ], 'public/assets/js/frontend/student/blog.js')
    .js([
        'resources/js/frontend/transactions.js'
    ], 'public/assets/js/frontend/transactions.js')
    .js([
        'resources/js/frontend/student/cart.js'
    ], 'public/assets/js/frontend/student/cart.js')
    .js([
        'resources/js/frontend/payment-method.js'
    ], 'public/assets/js/frontend/payment-method.js')
    .js([
        'resources/js/frontend/schedule.js'
    ], 'public/assets/js/frontend/schedule.js')
    .js([
        'resources/js/frontend/tutor/subscription.js'
    ], 'public/assets/js/frontend/tutor/subscription.js')
    .js([
        'resources/js/frontend/student/chat.js'
    ], 'public/assets/js/frontend/student/chat.js')
    .js([
        'resources/js/frontend/tutor/chat.js'
    ], 'public/assets/js/frontend/tutor/chat.js')
    .js([
        'resources/js/frontend/tutor/feedback/feedback.js'
    ], 'public/assets/js/frontend/tutor/feedback/feedback.js')
    .js([
        'resources/js/frontend/student/feedback.js'
    ], 'public/assets/js/frontend/student/feedback.js')
    .js([
        'resources/js/frontend/tutor/feedback/tutor-feedback.js'
    ], 'public/assets/js/frontend/tutor/feedback/tutor-feedback.js')
    .js([
        'resources/js/frontend/global-search.js'
    ], 'public/assets/js/frontend/global-search.js')
    .js([
        'resources/js/frontend/share.js'
    ], 'public/assets/js/frontend/share.js')
    .js([
        'resources/js/frontend/referral-code/index.js'
    ], 'public/assets/js/frontend/referral-code/index.js')
    .js([
        'resources/js/frontend/rating.js'
    ], 'public/assets/js/frontend/rating.js');

mix.js([
        'resources/js/accountant/auth/login.js'
    ], 'public/assets/js/accountant/auth/login.js')
    .js([
        'resources/js/accountant/profile/profile.js'
    ], 'public/assets/js/accountant/profile/profile.js')
    .js([
        'resources/js/accountant/auth/forget-password.js'
    ], 'public/assets/js/accountant/auth/forget-password.js')
    .js([
        'resources/js/accountant/auth/reset-password.js'
    ], 'public/assets/js/accountant/auth/reset-password.js')
    .js([
        'resources/js/accountant/tutors/index.js'
    ], 'public/assets/js/accountant/tutors/index.js')
    .js([
        'resources/js/accountant/tutors/tutor-view.js'
    ], 'public/assets/js/accountant/tutors/tutor-view.js')
    .js([
        'resources/js/accountant/reports/revenue-report.js'
    ], 'public/assets/js/accountant/reports/revenue-report.js')
    .js([
        'resources/js/accountant/supports/index.js'
    ], 'public/assets/js/accountant/supports/index.js')
    .js([
        'resources/js/accountant/dashboard/dashboard.js'
    ], 'public/assets/js/accountant/dashboard/dashboard.js')
    .js([
        'resources/js/accountant/refund-request/index.js'
    ], 'public/assets/js/accountant/refund-request/index.js')
    .js([
        'resources/js/frontend//payment-success-failed.js'
    ], 'public/assets/js/frontend//payment-success-failed.js');


    mix.js([
        'resources/js/frontend/tutor/rating.js'
    ], 'public/assets/js/frontend/tutor/rating.js');

    mix.js([
        'resources/js/admin/demo/demo.js'
    ], 'public/assets/js/admin/demo/demo.js');

    mix.js([
        'resources/js/frontend/student/class-request.js'
    ], 'public/assets/js/frontend/student/class-request.js');

    mix.js([
        'resources/js/frontend/tutor/class-request.js'
    ], 'public/assets/js/frontend/tutor/class-request.js');

    mix.js([
        'resources/js/frontend/tutor/quote.js'
    ], 'public/assets/js/frontend/tutor/quote.js');


    mix.js([
        'resources/js/frontend/student/tutor-class-request.js'
    ], 'public/assets/js/frontend/student/tutor-class-request.js');


    






    


    


   
    
    