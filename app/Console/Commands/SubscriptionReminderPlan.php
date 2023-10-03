<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionReminderPlan as MailSubscriptionReminderPlan;
use App\Models\TutorSubscription;
use Illuminate\Console\Command;
use App\Repositories\TutorSubscriptionRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

/**
 * Subscription Reminder plan command
 */
class SubscriptionReminderPlan extends Command
{

    public $tutorSubscriptionRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After every 1 month if they have still not
     upgraded their basic plan';

    /**
     * Create a new command instance.
     *
     * @param Application                 $app 
     * @param TutorSubscriptionRepository $tutorSubscriptionRepository  
     * 
     * @return void
     */
    public function __construct(
        Application $app,
        TutorSubscriptionRepository $tutorSubscriptionRepository
    ) {
        parent::__construct($app);
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return object
     */
    public function handle()
    {
        $monthBefore = Carbon::now()->subDays(30)->format('Y-m-d');

        TutorSubscription::where("status", TutorSubscription::ACTIVE)
            ->whereDate('updated_at', $monthBefore)
            ->whereNotNull('updated_at')
            ->whereHas(
                "subscription",
                function ($query) {
                    $query->where("default_plan", "Yes");
                }
            )
            ->whereHas(
                "tutor",
                function ($query) {
                    $query->where(
                        "approval_status",
                        User::APPROVAL_STATUS_APPROVED
                    );
                }
            )
            ->chunk(
                100,
                function ($subscriptions) {                    
                    foreach ($subscriptions as $subscription) {
                        $emailTemplate = new MailSubscriptionReminderPlan($subscription);
                        sendMail($subscription->tutor->email, $emailTemplate);
                        $subscription->updated_at = Carbon::now();
                        $subscription->save();
                    }
                }
            );
    }
}
