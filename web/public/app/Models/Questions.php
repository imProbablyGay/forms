<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function options(){
        return $this->hasMany(Options::class, 'q_id', 'id');
    }
}
