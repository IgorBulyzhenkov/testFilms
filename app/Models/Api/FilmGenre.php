<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmGenre extends Model
{
    use HasFactory;

    protected $table    = 'film_genre';

    public $timestamps  = false;

    protected $fillable = [
        'fk_film',
        'fk_genre'
    ];
}
