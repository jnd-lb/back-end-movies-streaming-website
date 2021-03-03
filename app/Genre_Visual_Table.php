<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre_Visual_Table extends Model
{
    protected $table = 'genre_visuals';
    protected $fillable = ['vidsual_id','genre_id'];
}
