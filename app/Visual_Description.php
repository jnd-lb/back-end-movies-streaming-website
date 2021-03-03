<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visual_Description extends Model
{
    protected $table = 'visuals_description';
    protected $fillable = ['description_in_arabic','description_in_english'];
}
