<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to_id', 'from_id', 'type', 'notification_message', 'notification_data'
    ];
    /**
     * Method fromUser
     *
     * @return void
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }

    /**
     * Method fromUser
     *
     * @return void
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }
    
    /**
     * Method scopeOnlyUnread
     *
     * @param $query $query [explicite description]
     *
     * @return void
     */
    public function scopeOnlyUnread($query)
    {
        return $query->where('is_read', '0');
    }
    
    /**
     * Method getAdminNotifications
     *
     * @param User $user     [explicite description]
     * @param int  $limit    [explicite description]
     * @param bool $isUnread [explicite description]
     *
     * @return Collection|null
     */
    public static function getNotifications(
        ?User $user,
        int $limit = 10,
        $isUnread = false
    ) {
        if (!$user) {
            return null;
        }

        $query = Notification::where('to_id', $user->id);
        if ($isUnread) {
            $query->onlyUnread();
        }

        return $query->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Method NotificationCounts
     *
     * @param User $user [explicite description]
     *
     * @return Collection|null
     */
    public static function notificationCounts(User $user)
    {
        return Notification::where('to_id', $user->id)->onlyUnread()->count();
    }

    /**
     * Method type
     *
     * @param string $type 
     *
     * @return string
     */
    public static function type($type) :string
    {
        switch ($type) {
        case 'student_send_class_reminder':
            return trans(
                'message.class_start_notification_title',
                ["type" => trans('labels.class')]
            );
            break;
        case 'student_send_webinar_reminder':
            return trans(
                'message.class_start_notification_title',
                ["type" => trans('labels.webinar')]
            );
            break;
        case 'student_class_cancel':
            return trans(
                'message.class_cancel_notification_title',
                ["type" => trans('labels.class')]
            );
            break;
        case 'student_webinar_cancel':
            return trans(
                'message.class_cancel_notification_title',
                ["type" => trans('labels.webinar')]
            );
            break;
        case 'class_completed':
            return  trans(
                'message.class_completed_notification_title',
                ["type" => trans('labels.class')]
            );
        case 'webinar_completed':
            return  trans(
                'message.class_completed_notification_title',
                ["type" =>  trans('labels.webinar')]
            );
            break;
        case 'tutor_signup_assign_subscription_plan':
            return  trans(
                'message.signup_plan_assign_notification_title'
            );
            break;
        case 'tutor_class_cancel':
            return  trans(
                'message.tutor_cancelled_class_title',
                ['type' => trans('labels.class')]
            );
            break;
        case 'tutor_webinar_cancel':
            return  trans(
                'message.tutor_cancelled_class_title',
                ['type' => trans('labels.webinar')]
            );
            break;
        case 'tutor_received_feedback':
            return  trans(
                'message.tutor_feedback_notification_title'
            );
            break;
        case 'student_raise_dispute':
            return  trans(
                'message.student_raise_dispute_title'
            );
            break;
        case 'tutor_send_class_reminder':
            return trans(
                'message.tutor_class_notification_title',
                ["type" => trans('labels.class')]
            );
            break;
        case 'tutor_send_webinar_reminder':
            return trans(
                'message.tutor_class_notification_title',
                ["type" => trans('labels.webinar')]
            );
            break;
        case 'referral_code_used':
            return trans(
                'message.referral_code_used_title'
            );
            break;
        case 'tutor_webinar_booked':
            return trans(
                'message.tutor_booking_notification_title',
                ["type" => trans('labels.webinar')]
            );
            break;
        case 'tutor_class_booked':
            return trans(
                'message.tutor_booking_notification_title',
                ["type" => trans('labels.class')]
            );
            break;
        case 'tutor_class_webinar_booked':
            return trans(
                'message.tutor_booking_notification_title',
                ["type" => trans('message.class_webinar')]
            );
            break;
        case 'admin_tutor_signup':
            return trans(
                'message.admin_tutor_signup_title'               
            );
            break;
        case 'reward_point':
            return  trans(
                'message.reward_point'
            );
            break;
        default:
            return $type;
            break;
        }
    }
}
