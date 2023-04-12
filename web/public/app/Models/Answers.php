<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    public function answers_options(){
        return $this->hasMany(AnswersOptions::class, 'answer_id', 'id');
    }
}
