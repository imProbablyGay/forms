<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
   public static function sendByEmail($email, $email_template)
   {
       Mail::to($email)->send($email_template);
   }
}
