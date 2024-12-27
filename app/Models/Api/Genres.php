<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    use HasFactory;

    protected $table    = 'genres';

    public $timestamps  = false;

    protected $fillable = [
        'name'
    ];

    public function films(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Films::class, 'film_genre', 'fk_genre', 'fk_film');
    }
}
