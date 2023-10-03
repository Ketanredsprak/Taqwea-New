<?php
namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Exception;
use App\Repositories\TutorRepository;
use Carbon\Carbon;

/**
 * Class SubscriptionService
 */
class TopUpService
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
     * Method upgradeTutorTopUp
     *
     * @param array $params 
     * 
     * @return void
     */
    public function upgradeTutorTopUp($params)
    {

        $tutor = $this->tutorRepository
            ->getTutor($params["user"]->id);
        $data = [];

        // Check carry forward 
        $blog = !empty($tutor->blog) ? $tutor->blog : 0;
        $class_hours = !empty($tutor->class_hours) ? $tutor->class_hours : 0;
        $webinar_hours = !empty($tutor->webinar_hours) ? $tutor->webinar_hours : 0;

        if ($params['class_hours']) {
            $data["class_hours"] = $class_hours + $params['class_hours'];
        }

        if ($params['webinar_hours']) {
            $data["webinar_hours"] = $webinar_hours + $params['webinar_hours'];
        }

        if ($params['blog_count']) {
            $data["blog"] = $blog + $params['blog_count'];
        }

        if ($params['is_featured']) {
            $data["is_featured"] = 1;
            $endDate = Carbon::now();
            $endDate->addDays($params['is_featured']);
            $data["is_featured_end_date"] = $endDate;
        }

        //Update the data
        if (!empty($data)) {
            $this->tutorRepository
                ->updateTutor($params['user'], $data);
        }
    }
}
