<?php

namespace App\Providers;

use App\Events\BookingEvent;
use App\Events\ClassCancelEvent;
use App\Events\ClassCompletedEvent;
use App\Events\FeedbackEvent;
use App\Events\PointCreditDebitEvent;
use App\Events\ReferralCodeUsedEvent;
use App\Events\RequestDisputeEvent;
use App\Events\TutorSignUpEvent;
use App\Events\TutorSignUpSubscriptionEvent;
use App\Events\TutorFineEvent;
use App\Events\UpdateIsFineCollectedForTutorPayOutEvent;
use App\Listeners\NotifyAdminTutorSignUp;
use App\Listeners\NotifyBooking;
use App\Listeners\NotifyClassCancel;
use App\Listeners\NotifyClassCompleted;
use App\Listeners\NotifyFeedback;
use App\Listeners\NotifyPointCreditDebit;
use App\Listeners\NotifyReferralCodeUsed;
use App\Listeners\NotifyRequestDispute;
use App\Listeners\NotifyTutorBooking;
use App\Listeners\NotifyTutorSignUpSubscription;
use App\Listeners\NotifyTutorFine;
use App\Listeners\UpdateIsFineCollectedForTutorPayOut;
use App\Models\Blog;
use App\Models\ClassWebinar;
use App\Models\User;
use App\Observers\BlogObserver;
use App\Observers\ClassObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            'SocialiteProviders\\Apple\\AppleExtendSocialite@handle',
        ],
        ClassCancelEvent::class => [
            NotifyClassCancel::class,
        ],
        ClassCompletedEvent::class => [
            NotifyClassCompleted::class,
        ],
        BookingEvent::class => [
            NotifyBooking::class,
            NotifyTutorBooking::class,
        ],
        TutorSignUpSubscriptionEvent::class => [
            NotifyTutorSignUpSubscription::class,
        ],
        TutorSignUpEvent::class => [
            NotifyAdminTutorSignUp::class,
        ],
        RequestDisputeEvent::class => [
            NotifyRequestDispute::class,
        ],
        FeedbackEvent::class => [
            NotifyFeedback::class,
        ],
        ReferralCodeUsedEvent::class => [
            NotifyReferralCodeUsed::class,
        ],
        PointCreditDebitEvent::class => [
            NotifyPointCreditDebit::class,
        ],
        TutorFineEvent::class => [
            NotifyTutorFine::class,
        ],
        UpdateIsFineCollectedForTutorPayOutEvent::class => [
            UpdateIsFineCollectedForTutorPayOut::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        User::observe(UserObserver::class);
        Blog::observe(BlogObserver::class);
        ClassWebinar::observe(ClassObserver::class);
    }
}
