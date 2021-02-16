<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['type_in_english', 'type_in_arabic'];

    // relations
    public function visuals() {
        $this->belongsToMany(Visual::class);
    }

}
