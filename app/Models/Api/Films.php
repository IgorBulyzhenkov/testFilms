<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;

    protected $table    = 'films';

    public $timestamps  = false;

    protected $fillable = [
        'name',
        'status_published',
        'link_poster'
    ];

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genres::class, 'film_genre', 'fk_film', 'fk_genre');
    }

}
