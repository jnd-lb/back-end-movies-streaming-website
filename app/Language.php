<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'language_in_english',
        'language_in_arabic',
    ];

    public function visuals() {
        return $this->hasMany(Visual::class, 'language_id');
    }
}
