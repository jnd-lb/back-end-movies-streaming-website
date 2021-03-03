<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
      protected $table ='types';
    protected $fillable = ['type_in_english', 'type_in_arabic'];

    // relations
    public function visuals() {
        $this->hasMany(Visual::class, 'type_id');
    }

}
