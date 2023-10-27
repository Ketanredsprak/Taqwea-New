<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class ClassRequest extends Model

{

    //

    protected $table = 'class_requests';



    protected $fillable = [

        'level_id',

        'class_type',

        'subject_id',

        'preferred_gender',

        'grade_id',

        'class_duration',

        'request_time',

        'expired_time',

        'class_time',

        'user_id',

        'status',

        'category_id',

        'start_time',

        'end_time',

        'name',

        'note',

        'won_quote_id'

    ];



    public function classRequestDetails()

    {

        return $this->hasMany(ClassRequestDetail::class, 'class_request_id');

    }



    public function tutorAllRequest()

    {

        return $this->hasMany(TutorRequest::class, 'class_request_id');

    }



    public function subjects()

    {

        return $this->hasOne(Subject::class, 'id','subject_id');

    }

    public function levels()

    {

        return $this->hasOne(Category::class, 'id','level_id');

    }

    public function categories()

    {

        return $this->hasOne(Category::class, 'id','category_id');

    }

    public function grades()

    {

        return $this->hasOne(Grade::class, 'id','grade_id');

    }


    // public function userdata(){
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }

}

