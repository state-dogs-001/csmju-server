<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'detail',
        'poster',
        'link',
        'type',
        'is_show',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function informationImages()
    {
        return $this->hasMany('App\Models\InformationImage', 'information_id');
    }

    public function getPosterAttribute($value)
    {
        if ($value) {
            return asset('images/news/posters/' . $value);
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
                    'image' => asset('images/news/images/' . $image),
                ];

                array_push($images, $url);
            }
            return $images;
        }
    }
}
