<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table ='types';
    protected $fillable = ['type_in_english','type_in_arabic'];
    
    public function visual()
    {
        return $this->hasmany (Visual::class);
    }
}
