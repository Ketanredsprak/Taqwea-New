<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User
 */
class User extends Authenticatable implements TranslatableContract, JWTSubject, CanResetPassword, HasLocalePreference
{
    use Notifiable, Translatable, SoftDeletes, PasswordsCanResetPassword;

    public const TYPE_ADMIN = 'admin';
    public const TYPE_ACCOUNTANT = 'accountant';
    public const TYPE_STUDENT = 'student';
    public const TYPE_TUTOR = 'tutor';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_BLOCKED = 'blocked';
    public const SOCIAL_LOGIN = 'social';
    public const NORMAL_LOGIN = 'normal';
    public const APPROVAL_STATUS_PENDING = 'pending';
    public const APPROVAL_STATUS_APPROVED = 'approved';
    public const APPROVAL_STATUS_REJECTED = 'rejected';
    public const MALE = 'male';
    public const FEMALE = 'female';

    public $translatedAttributes = ['name', 'bio'];

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->language;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'otp', 'account_verified_at', 'user_type',
        'profile_image', 'address', 'phone_code', 'phone_number',
        'is_verified', 'status', 'language', 'is_profile_completed', 'is_approved',
        'approval_status', 'gender', 'is_force_logout', 'updated_at', 'time_zone','is_available',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_image_url',
    ];

    /**
     * Method saveWithoutEvents
     *
     * @param array $options [explicite description]
     *
     * @return void
     */
    public function saveWithoutEvents(array $options = [])
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
    public function getProfileImageUrlAttribute()
    {
        if (filter_var($this->profile_image, FILTER_VALIDATE_URL)) {
            $url = $this->profile_image;
        } else {
            $url = getImageUrl($this->profile_image);
        }

        return $url;
    }

    /**
     * Method levels
     *
     * @return mixed
     */
    public function levels()
    {
        return $this->belongsToMany(
            Category::class,
            UserLevel::class,
            'user_id',
            'category_id'
        )->withPivot('category_id', 'user_id')->withTimestamps();
    }

    /**
     * Method grades
     *
     * @return mixed
     */
    public function grades()
    {
        return $this->belongsToMany(
            Grade::class,
            UserGrade::class,
            'user_id',
            'grade_id'
        )->withPivot('grade_id', 'user_id')->withTimestamps();
    }

    /**
     * Method subjects
     *
     * @return mixed
     */
    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            UserSubject::class,
            'user_id',
            'subject_id'
        )->withPivot('subject_id', 'user_id')->withTimestamps();
    }

    /**
     * Method languages
     *
     * @return mixed
     */
    public function languages()
    {
        return $this->belongsToMany(
            Category::class,
            UserLanguage::class,
            'user_id',
            'category_id'
        )->withPivot('category_id', 'user_id')->withTimestamps();
    }

    /**
     * Method generalKnowledge
     *
     * @return mixed
     */
    public function generalKnowledge()
    {
        return $this->belongsToMany(
            Category::class,
            UserGeneralKnowledge::class,
            'user_id',
            'category_id'
        )->withPivot('category_id', 'user_id')->withTimestamps();
    }

    /**
     * Method tutor
     *
     * @return mixed
     */
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    /**
     * Method userTranslation
     *
     * @return void
     */
    public function userTranslation()
    {
        return $this->belongsTo(UserTranslation::class, 'id', 'user_id');
    }

    /**
     * Method transaction
     *
     * @return void
     */
    public function ratingReview()
    {
        return $this->belongsTo(RatingReview::class, 'id', 'to_id');
    }

    /**
     * Method ratingReviews
     *
     * @return void
     */
    public function ratingReviews()
    {
        return $this->hasMany(RatingReview::class, 'to_id');
    }

    /**
     * Method certificates
     *
     * @return mixed
     */
    public function certificates()
    {
        return $this->hasMany(TutorCertificate::class, 'tutor_id');
    }

    /**
     * Method educations
     *
     * @return mixed
     */
    public function educations()
    {
        return $this->hasMany(TutorEducation::class, 'tutor_id');
    }

    /**
     * Method device
     *
     * @return mixed
     */
    public function device()
    {
        return $this->hasOne(UserDevice::class);
    }

    /**
     * Method devices
     *
     * @return mixed
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Method educations
     *
     * @return mixed
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'tutor_id');
    }

    /**
     * Method TutorSubscriptions
     *
     * @return mixed
     */
    public function tutorSubscriptions()
    {
        return $this->hasOne(TutorSubscription::class);
    }

    /**
     * Method ClassRefundRequests
     *
     * @return mixed
     */
    public function classRefundRequests()
    {
        return $this->hasOne(ClassRefundRequest::class);
    }

    /**
     * Method getJWTIdentifier
     *
     * @return void
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Method getJWTCustomClaims
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Method scopeByStatus
     *
     * @param Builder $query  [explicite description]
     * @param $status $status [explicite description]
     *
     * @return void
     */
    public function scopeByStatus($query, $status = null)
    {
        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Method scopeNotAdmin
     *
     * @param $query $query [explicite description]
     *
     * @return void
     */
    public function scopeNotAdmin($query)
    {
        return $query->where('user_type', '<>', User::TYPE_ADMIN);
    }

    /**
     * Method scopeNotAdmin
     *
     * @param $query $query [explicite description]
     *
     * @return void
     */
    public function scopeOnlyAdmins($query)
    {
        return $query->where('user_type', User::TYPE_ADMIN);
    }

    /**
     * Method isTutor
     *
     * @return bool
     */
    public function isTutor(): bool
    {
        return $this->user_type == self::TYPE_TUTOR;
    }

    /**
     * Method isStudent
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->user_type == self::TYPE_STUDENT;
    }

    /**
     * Method isAdmin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_type == self::TYPE_ADMIN;
    }

    /**
     * Method isAccountant
     *
     * @return bool
     */
    public function isAccountant(): bool
    {
        return $this->user_type == self::TYPE_ACCOUNTANT;
    }

    /**
     * Method userSocialLogin
     *
     * @return mixed
     */
    public function userSocialLogin()
    {
        return $this->hasOne(UserSocialLogin::class);
    }

    /**
     * Method paymentMethod
     *
     * @return mixed
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Get admin details
     *
     * @return object
     */
    public static function getAdmin(): object
    {
        return self::where("user_type", self::TYPE_ADMIN)->first();
    }

    /**
     * Get accountant details
     *
     * @return object
     */
    public static function getAccountant(): object
    {
        return self::where("user_type", self::TYPE_ACCOUNTANT)->first();
    }

    /**
     * Method TutorSubscription
     *
     * @return mixed
     */
    public function tutorSubscription()
    {
        return $this->hasOne(TutorSubscription::class)
            ->where('status', TutorSubscription::ACTIVE);
    }
}
