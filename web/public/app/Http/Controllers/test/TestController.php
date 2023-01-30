<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms;

class TestController extends Controller
{
   public function test(){
    $user = Forms::with(['user'])->get();
    dd($user->find(3)->user->name);
   }
}
