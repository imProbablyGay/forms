<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    public $timestamps = false;

    function question()
    {
        return $this->belongsTo(Questions::class, 'q_id', 'id');
    }
}
