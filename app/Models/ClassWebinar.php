<?php

namespace App\Models;

use App\Traits\ClassExists;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ClassWebinar extends Model implements TranslatableContract
{
    use Translatable, ClassExists;

    public const TYPE_CLASS = "class";
    public const TYPE_WEBINAR = "webinar";

    public const STATUS_ACTIVE = "active";
    public const STATUS_INACTIVE = "inactive";
    public const STATUS_COMPLETED = "completed";
    public const STATUS_CANCELLED = "cancelled";
    public const STARTED = "started";
    public const MALE_CLASSES = ['male', 'both'];
    public const FEMALE_CLASSES = ['female', 'both'];

    public $translatedAttributes = [
        'class_name', 'class_description', 'class_detail'
    ];

    protected $fillable = [
        'tutor_id', 'category_id', 'level_id', 'grade_id', 'subject_id',
        'class_type', 'hourly_fees', 'total_fees', 'extra_hour_charge',
        'no_of_attendee', 'duration', 'status', 'class_image', 'start_time',
        'end_time', 'gender_preference', 'is_started', 'parent_id', 'extra_duration',
        'is_published', 'uuid','room_token'
    ];

    protected $appends = [
        'class_image_url'
    ];
    
    /**
     * Method saveWithoutEvents
     *
     * @param array $options [explicite description]
     *
     * @return void
     */
    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(
            function () use ($options) {
                return $this->save($options);
            }
        );
    }

    /** 
     * Method getProfileImageUrlAttribute
     *
     * @return string
     */
    public function getClassImageUrlAttribute()
    {
        return getImageUrl($this->class_image);
    }

    /**
     * Method tutor
     *
     * @return mixed
     */
    public function tutor()
    {
        return $this->belongsTo(
            User::class,
            'tutor_id',
            'id'
        );
    }

    /**
     * Method category
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }

    /**
     * Method grade
     *
     * @return mixed
     */
    public function grade()
    {
        return $this->belongsTo(
            Grade::class,
            'grade_id',
            'id'
        );
    }

    /**
     * Method level
     *
     * @return mixed
     */
    public function level()
    {
        return $this->belongsTo(
            Category::class,
            'level_id',
            'id'
        );
    }

    /**
     * Method subject
     *
     * @return mixed
     */
    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'id'
        );
    }

    /**
     * Method topics
     *
     * @return mixed
     */
    public function topics()
    {
        return $this->hasMany(
            ClassTopic::class,
            'class_id',
            'id'
        );
    }
    
    /**
     * Method bookings
     *
     * @return mixed
     */
    public function bookings()
    {
        return $this->hasMany(
            ClassBooking::class,
            'class_id',
            'id'
        );
    }
    
    /**
     * Method classCount
     *
     * @param int    $tutorId 
     * @param string $type 
     * @param bool   $isCompleted 
     * 
     * @return int
     */
    public static function classCount(
        int $tutorId,
        string $type = self::TYPE_CLASS,
        bool $isCompleted = true,
        array $params = []
    ):int {
        $query = self::where('class_type', $type)
            ->where('tutor_id', $tutorId);
        
        if ($isCompleted) {
            $query->where('status', self::STATUS_COMPLETED);    
        }

        if (!empty($params['userTimezone'])
            && !empty($params['schedule_date'])
        ) {
            $query->whereRaw(
                "DATE(
                    CONVERT_TZ(
                        start_time, '+00:00', '" . $params['userTimezone'] . "')
                    ) = '" . $params['schedule_date'] . "'"
            );
        }

        return $query->count();
    }

    /**
     * Method classScheduleCount
     *
     * @param int    $tutorId 
     * @param string $userTimezone 
     * @param string $schedule_date 
     * 
     * @return int
     */
    public static function classScheduleCount(
        int $tutorId,
        string $userTimezone = '',
        $schedule_date = ''
    ):int {
        $query = self::where('tutor_id', $tutorId);
        $query->where(
            'status',
            self::STATUS_ACTIVE,
        );

        if ($userTimezone && $schedule_date) {
            $query->whereRaw(
                "DATE(
                    CONVERT_TZ(
                        start_time, '+00:00', '" . $userTimezone . "')
                    ) = '" . $schedule_date . "'"
            );
        }

        return $query->count();
    }

    /**
     * Method cartItem
     * 
     * @return mixed
     */
    public function cartItem()
    {
        return $this->belongsTo(
            CartItem::class,
            'id',
            'class_id'
        );
    }

    /**
     * Method topics
     *
     * @return mixed
     */
    public function chatThread()
    {
        return $this->hasOne(
            Thread::class,
            'class_id',
            'id'
        );
    }

    /**
     * Method class
     *
     * @return mixed
     */
    public function rating()
    {
        return $this->hasOne(RatingReview::class, 'class_id', 'id');
    }

    /**
     * Method class
     *
     * @return mixed
     */
    public function raiseDispute()
    {
        return $this->hasOne(ClassRefundRequest::class, 'class_id', 'id');
    }


}
