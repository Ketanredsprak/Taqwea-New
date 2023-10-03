<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Message;
use App\Models\User;
use App\Models\CmsPage;
use App\Models\RewardPoint;
use App\Models\CartItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS', 'on');
        }
        Schema::defaultStringLength(191);
        View::composer(
            [
                'admin/*',
                'accountant/*',
                'frontend/*'
            ],
            function ($view) {
                if (Auth::check()) {
                    /**
                     * User
                     * 
                     * @var $loggedInUser User 
                     **/
                    $loggedInUser = Auth::user();
                    if ($loggedInUser->isAdmin()) {
                        $view->with('cmsPage', CmsPage::withTranslation()->get());
                    }
                    $view->with(
                        'headerNotifications',
                        Notification::getNotifications(Auth::user(), 5, true)
                    );
                    $view->with(
                        'headerChattingNotifications',
                        Message::getUnReadCount(Auth::user())
                    );
                    $view->with(
                        'cartCount',
                        CartItem::getCount(Auth::user()->id)
                    );
                }
            }
        );

        Validator::extend(
            'check_email_exist',
            function ($attribute, $value) {
                $emailExists = DB::table('users')
                    ->where($attribute, $value)
                    ->where('status', '!=', User::STATUS_INACTIVE)
                    ->whereNull('deleted_at')
                    ->first();
                if (empty($emailExists)) {
                    return true;
                }

                return false;
            }
        );

        Validator::extend(
            'check_email_format',
            function ($attribute, $value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                return true;
            }
        );

        Validator::extend(
            'validate_current_password',
            function ($attribute, $value) {
                $user = auth()->user();
                if (!empty($user)) {
                    return Hash::check($value, $user->password);
                }
                return false;
            }
        );

        Validator::extend(
            'validate_new_password',
            function ($attribute, $value, $parameters) {
                if (!empty($parameters[0])) {
                    $userId = $parameters[0];
                    $user = User::where('id', $userId)->first();
                } else {
                    $user = auth()->user();
                }
                if (!empty($user)) {
                    return !Hash::check($value, $user->password);
                }
                return true;
            }
        );

        Validator::extend(
            'check_phone_exist',
            function ($attribute, $value) {
                $phoneExists = DB::table('users')
                    ->where($attribute, $value)
                    ->where('status', '!=', User::STATUS_INACTIVE)
                    ->whereNull('deleted_at')
                    ->first();
                if (empty($phoneExists)) {
                    return true;
                }
                return false;
            }
        );

        Validator::extend(
            'user_not_exists',
            function ($attribute, $value, $parameters) {
                return DB::table('users')
                    ->where($attribute, $value)
                    ->where($parameters[0], $parameters[1])
                    ->whereNull('deleted_at')
                    ->count() < 1;
            }
        );

        Validator::extend(
            'older_than',
            function ($attribute, $value, $parameters) {
                $minAge = (!empty($parameters)) ? (int) $parameters[0] : 16;
                return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
            }
        );

        Validator::extend(
            'check_max_points',
            function ($attribute, $value, $parameters) {
                $user = auth()->user();
                if ($user) {
                    $points = RewardPoint::getUserPoints($user->id);
                    if ($value > $points) {
                        return false;
                    }
                }

                return true;
            }
        );
    }
}
