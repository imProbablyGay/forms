<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorsController extends Controller
{
    public function not_found()
    {
        return view('errors.404');
    }
}
