<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $fillable = [
        'name',
        'status_published',
        'link_poster'
    ];

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genres::class, 'film_genre', 'fk_film', 'fk_genre');
    }

//    protected static function boot()
//    {
//        static::created(function ($model) {
//            $randomGenre = Genres::inRandomOrder()->first();
//            if ($randomGenre) {
//                $model->genres()->attach($randomGenre->id);
//            }
//        });
//
//        parent::boot();
//    }
}
