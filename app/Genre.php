<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    protected $table = 'genre';
    protected $fillable = [
        'genre_in_arabic' , 'genre_in_english'
    ];
}
