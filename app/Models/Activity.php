<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organizer',
        'date_start',
        'date_end',
        'detail',
        'location',
        'poster',
        'is_show',
    ];

    protected $casts = [
        'date_start' => 'date:Y-m-d',
        'date_end' => 'date:Y-m-d',
        'is_show' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function activityImages()
    {
        return $this->hasMany('App\Models\ActivityImage', 'activity_id');
    }

    public function activityDoc()
    {
        return $this->hasOne('App\Models\ActivityDoc', 'activity_id');
    }

    public function getPosterAttribute($value)
    {
        if ($value) {
            return asset('images/activities/posters/' . $value);
        }
    }

    public function getImagesAttribute($value)
    {
        if ($value) {
            //? Split , to array
            $imageSplit = explode(',', $value);

            $images = [];
            //? Loop array
            foreach ($imageSplit as $image) {
                $url = [
                    'image' => asset('images/activities/images/' . $image),
                ];

                //? push url image to images array
                array_push($images, $url);
            }
            return $images;
        }
    }

    public function getDocsAttribute($value)
    {
        if ($value) {
            //? Split , to array
            $docSplit = explode(',', $value);

            $docs = [];
            //? Loop array
            foreach ($docSplit as $doc) {
                $url = [
                    'doc' => asset('documents/activities/' . $doc),
                ];

                //? push url image to images array
                array_push($docs, $url);
            }
            return $docs;
        }
    }
}
