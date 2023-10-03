<?php

namespace App\Providers;

use App\Models\ClassWebinar;
use App\Models\ExtraHourRequest;
use App\Models\RaiseHand;
use App\Models\TutorCertificate;
use App\Models\TutorEducation;
use App\Policies\ClassWebinarPolicy;
use App\Policies\ExtraHourRequestPolicy;
use App\Policies\RaiseHandPolicy;
use App\Policies\TutorCertificatePolicy;
use App\Policies\TutorEducationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        TutorCertificate::class => TutorCertificatePolicy::class,
        TutorEducation::class => TutorEducationPolicy::class,
        ClassWebinar::class => ClassWebinarPolicy::class,
        RaiseHand::class => RaiseHandPolicy::class,
        ExtraHourRequest::class => ExtraHourRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
