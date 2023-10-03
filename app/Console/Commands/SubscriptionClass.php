<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TutorSubscription;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\Wallet;
use App\Repositories\TutorSubscriptionRepository;
use App\Repositories\subscriptionRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Log;
use App\Mail\AutoUpgradeBasicPlan;
class SubscriptionClass extends Command
{

    protected $tutorSubscriptionRepository;

    protected $subscriptionRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription plan expiry date
        and revenue subscription plan';

        
    /**
     * Method __construct
     *
     * @param Application                 $app 
     * @param TutorSubscriptionRepository $tutorSubscriptionRepository 
     * @param SubscriptionRepository      $subscriptionRepository 
     * 
     * @return void
     */
    public function __construct( 
        Application $app,
        TutorSubscriptionRepository $tutorSubscriptionRepository,
        SubscriptionRepository $subscriptionRepository
    ) {
        parent::__construct($app);
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $todayDate = currentDateByFormat('Y-m-d');
        TutorSubscription::where("status", TutorSubscription::ACTIVE)
            ->where("end_date", "<", $todayDate)
            ->whereNotNull('end_date')
            ->chunk(
                100,
                function ($subscriptions) {

                    Log::channel('cron')
                        ->info(
                            "Tutor plan expired",
                            ["tutor" => $subscriptions->pluck('id')]
                        );

                    foreach ($subscriptions as $subscription) {
                        $params["user"] = $subscription->tutor;
                        $params["plan_id"] = $subscription->subscription_id;
                        $params["duration"] = $subscription->plan_duration;
                        $params["is_system"] = true;
                        
                        $params['gateway'] = Transaction::PAYMENT_GATEWAY_HYPERPAY;
                        $params['card_type'] = $subscription->card_type;
                        $params['currency'] = config('app.currency.default');

                        $params["amount"] 
                            = isset($subscription->transaction->total_amount)?
                            $subscription->transaction->total_amount:0;
                        $params['givenName'] = $subscription->tutor->name;
                        $params['email'] = $subscription->tutor->email;

                        $params['payment_method']
                            = Transaction::STATUS_WALLET;

                        $params['subscription_type'] 
                            = Subscription::RECURRING;

                       
                        $this->tutorSubscriptionRepository->purchasePlan($params);
                    }
                }
            );
    }
}
