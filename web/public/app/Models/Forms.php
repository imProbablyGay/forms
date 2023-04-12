<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    public function questions(){
        return $this->hasMany(Questions::class, 'form_id', 'id');
    }

    public function answers(){
        return $this->hasMany(Answers::class, 'form_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
