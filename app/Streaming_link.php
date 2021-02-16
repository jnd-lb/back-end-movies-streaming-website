<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Streaming_link extends Model
{
    protected $fillable = ['description', 'link'];

    public function visuals() {
        return $this->belongsToMany(Visual::class);
    }

    public function episodes() {
        return $this->belongsToMany(Episode::class);
    }
}


