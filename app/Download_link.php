<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download_link extends Model
{
    protected $fillable = ['download_link'];

    public function visuals() {
        return $this->belongsToMany(Visual::class);
    }

    public function episodes() {
        return $this->belongsToMany(Download_link::class);
    }

}
