<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visual_Description extends Model
{
    protected $table = 'description_visual';
    protected $fillable = ['description_in_arabic','description_in_english'];
}
