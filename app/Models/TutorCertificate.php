<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class TutorCertificate extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['certificate_name'];

    protected $fillable = ['tutor_id', 'certificate_name', 'certificate'];

    protected $appends = [
        'certificate_url', 'certificate_type', 'certificate_thumb'
    ];

    /** 
     * Method getCertificateUrlAttribute
     *
     * @return string
     */
    public function getCertificateUrlAttribute()
    {
        return getImageUrl($this->certificate, 'document');
    }

    /** 
     * Method getCertificateUrlAttribute
     *
     * @return string
     */
    public function getCertificateTypeAttribute()
    {
        return pathinfo($this->certificate, PATHINFO_EXTENSION);
    }

    /** 
     * Method getCertificateUrlAttribute
     *
     * @return string
     */
    public function getCertificateThumbAttribute()
    {
        $thumb = getImageUrl($this->certificate, 'document');
        if ($this->certificate_type == 'pdf') {
            $thumb = asset('assets/images/pdf-thumb.jpg');
        } elseif (in_array($this->certificate_type, ['doc', 'docx'])) {
            $thumb = asset('assets/images/document-thumb.png');
        }
        return $thumb;
    }
}
