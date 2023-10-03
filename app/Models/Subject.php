<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Storage;

class Subject extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['subject_name'];
    protected $fillable = ['subject_name','subject_icon'];

    protected $appends = [
        'subject_icon_url',
    ];


      /**
     * Method getSubjectIconUrlAttribute
     *
     * @return string
     */
    public function getSubjectIconUrlAttribute()
    {
        // $url = Storage::url($this->subject_icon);
        if($this->subject_icon != null)
        {
            return $url = Storage::url($this->subject_icon);
        }
        else {
            return $url = getImageUrl($this->subject_icon);
        }
    }


}
