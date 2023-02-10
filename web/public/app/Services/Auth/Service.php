<?php
namespace App\Services\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RestorePasswords;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Service
{
    function store($email)
    {
        $user = User::where('email', '=', $email)->first();
        $restore_link = uniqid();
        $this->restore_password_db($user->id, $restore_link); //save data to restore_passwords table
        $link = route('restore_password.index', $restore_link);

        Mail::to($user)->send(new ForgotPassword($link));
    }

    private function restore_password_db($id, $link) {
        $restore = new RestorePasswords;
        $restore->user_id = $id;
        $restore->time = Carbon::now()->timestamp;
        $restore->link = $link;
        $restore->save();
    }

    function restore_password($link, $password)
    {
        // get user id
        $user = RestorePasswords::where('link', '=', $link)->first();
        if (!$user) return redirect(route('not_found'));
        $user_id = $user->user_id;

        // update password
        $user = User::where('id', '=', $user_id)->first();
        $user->password = bcrypt($password);
        $user->save();

        // delete data from restore_passwords table
        RestorePasswords::where('user_id','=',$user_id)->delete();
    }
}

