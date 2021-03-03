<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable = ['visual_id' ,'description_in_arabic', 'description_in_english'];

    public function visuals() {
        return $this->belongsTo(Visual::class);
    }
}
