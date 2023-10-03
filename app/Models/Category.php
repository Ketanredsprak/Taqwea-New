<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Storage;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    public const HANDLE_EDUCATION = 'education';
    public const HANDLE_GK = 'general-knowledge';
    public const HANDLE_LANGUAGE = 'language';

    public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'handle', 'parent_id','icon'];

    protected $appends = [
        'icon_url',
    ];


    /**
     * Method grades
     *
     * @return mixed
     */
    public function grades()
    {
        return $this->belongsToMany(
            Grade::class,
            CategoryGrade::class,
            'category_id',
            'grade_id'
        )->withPivot('category_id', 'grade_id')->withTimestamps();
    }

    /**
     * Method childrens
     *
     * @return mixed
     */
    public function childrens()
    {
        return $this->hasMany(
            Category::class,
            'parent_id',
            'id'
        );
    }

      /**
     * Method getIconUrlAttribute
     *
     * @return string
     */
    public function getIconUrlAttribute()
    {
        // $url = Storage::url($this->icon);
        if($this->icon != null)
        {
            return $url = Storage::url($this->icon);
        }
        else {
            return $url = getImageUrl($this->icon);
        }
    }

}
