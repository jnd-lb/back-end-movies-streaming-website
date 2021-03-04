<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{ 
      protected $table = 'genres';
    protected $fillable = ['genre_in_arabic', 'genre_in_english'];

    public function visuals() {
        return $this->belongsToMany(Visual::class);
    }
 
}
