<?php
namespace App\Services;


use App\Repositories\TutorRepository;
use App\Models\Blog;
use App\Models\ClassWebinar;
use App\Models\ClassBooking;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Mail\PlanUpgrade;
/**
 * Class SubscriptionService
 */
class SubscriptionService
{
    protected $tutorRepository;

    /**
     * Method __construct
     *
     * @param TutorRepository $tutorRepository             
     * 
     * @return void
     */
    public function __construct(TutorRepository $tutorRepository) 
    {
        $this->tutorRepository = $tutorRepository;
    }

    /**
     * Method checkMonthlyCreation
     * 
     * @param string $type 
     * @param int    $duration 
     * 
     * @return void
     */
    public function checkCreation($type, $duration = 0) 
    {
        $user = Auth::user();
        $tutor = $this->tutorRepository->getTutor($user->id);
        $error = false;

        if ($type == Blog::BLOG_TYPE && $tutor->blog == 0) {
            throw new Exception(trans('error.upgrade_plan'));
        }

        if ($type == ClassWebinar::TYPE_CLASS && $duration > $tutor->class_hours) {
            throw new Exception(trans('error.upgrade_plan_class'));
        }

        if ($type == ClassWebinar::TYPE_WEBINAR && $duration > $tutor->webinar_hours) {
            throw new Exception(trans('error.upgrade_plan_webinar'));
        }
    }

    /**
     * Method upgradeTutorPlan
     *
     * @param object $newPlan 
     * @param array  $params 
     * @param object $oldPlan 
     * 
     * @return void
     */
    public function upgradeTutorPlan($newPlan, $params, $oldPlan = [])
    {
        if (!empty($oldPlan)) {
            // mail send
            $emailTemplate = new PlanUpgrade($newPlan);
            sendMail($newPlan->tutor->email, $emailTemplate);
        }
        

        $blog  = 0;
        $allow_booking = 0;
        $class_hours = 0;
        $webinar_hours = 0;
       
        // Check default plan (free)
        if (!empty($newPlan->subscription)
            && $newPlan->subscription->default_plan == "Yes"
            && !empty($oldPlan)
            && empty($params["is_system"])
        ) {
            return true;
        }

        // Get the data
        $tutor = $this->tutorRepository
            ->getTutor($params["user"]->id);

        // Check carry forward 
        if (!empty($oldPlan->subscription)
            && $oldPlan->subscription->default_plan != "Yes"
            && empty($params["is_system"])
        ) {

            $blog = !empty($tutor->blog) ? $tutor->blog : 0;
            $allow_booking = !empty($tutor->allow_booking) ? $tutor->allow_booking : 0;
            $class_hours = !empty($tutor->class_hours) ? $tutor->class_hours : 0;
            $webinar_hours = !empty($tutor->webinar_hours) ? $tutor->webinar_hours : 0;
        }

        $data = [
            "blog" => $blog + $newPlan->blog,
            "allow_booking" => $allow_booking + $newPlan->allow_booking,
            "class_hours" => $class_hours + $newPlan->class_hours,
            "webinar_hours" => $webinar_hours + $newPlan->webinar_hours,
        ];

        //Update the data
        $this->tutorRepository
            ->updateTutor($params['user'], $data);

    }
}
