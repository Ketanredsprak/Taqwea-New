<?php

namespace App\Observers;

use App\Models\ClassWebinar;
use Carbon\Carbon;
use App\Jobs\ThreadCreateJob;

class ClassObserver
{
    /**
     * Handle the class webinar "created" event.
     *
     * @param ClassWebinar $classWebinar
     *
     * @return void
     */
    public function created(ClassWebinar $classWebinar)
    {
        $defaultLocale = config('app.fallback_locale');
        $classWebinar->slug = makeSlug(
            $classWebinar->{"class_name:$defaultLocale"},
            ClassWebinar::class,
            'class_name'
        );
        $classWebinar->save();
    }

    /**
     * Handle the class webinar "updated" event.
     *
     * @param ClassWebinar $classWebinar
     *
     * @return void
     */
    public function updated(ClassWebinar $classWebinar)
    {
        $oldDuration = $classWebinar->getOriginal('duration');
        $oldStartTime = $classWebinar->getOriginal('start_time');
        if ($classWebinar->duration
            && ($oldDuration != $classWebinar->duration
            || $oldStartTime != $classWebinar->start_time)
        ) {
            $endtime = Carbon::parse($classWebinar->start_time)
                ->addMinutes($classWebinar->duration);
            $classWebinar->end_time = $endtime;
            $classWebinar->saveWithoutEvents();
        }
        if ($classWebinar->status == ClassWebinar::STATUS_COMPLETED) {
            ThreadCreateJob::dispatch($classWebinar->id);
        }
    }

    /**
     * Handle the class webinar "deleted" event.
     *
     * @param ClassWebinar $classWebinar
     *
     * @return void
     */
    public function deleted(ClassWebinar $classWebinar)
    {
        //
    }

    /**
     * Handle the class webinar "restored" event.
     *
     * @param ClassWebinar $classWebinar
     *
     * @return void
     */
    public function restored(ClassWebinar $classWebinar)
    {
        //
    }

    /**
     * Handle the class webinar "force deleted" event.
     *
     * @param ClassWebinar $classWebinar
     *
     * @return void
     */
    public function forceDeleted(ClassWebinar $classWebinar)
    {
        //
    }
}
