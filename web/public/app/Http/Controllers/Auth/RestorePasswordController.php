<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\BaseController;
use Illuminate\Http\Request;
use App\Models\RestorePasswords;
use Carbon\Carbon;


class RestorePasswordController extends BaseController
{
    public function index($link)
    {
        $restore = RestorePasswords::where('link', '=', $link)->first();
        if (!$restore) return redirect(route('not_found'));
        else if ($this->compare_timestamps_hours($restore->time) > 5) return redirect(route('not_found'));
        return view('auth.restore_password', ['restore' => $restore->link]);
    }

    private function compare_timestamps_hours($timestamp_arg)
    {
        $current_timestamp = Carbon::now()->timestamp;
        $difference = $current_timestamp - $timestamp_arg;
        $hours = $difference / 3600;
        return $hours;
    }

    public function update($link, Request $request)
    {
        $data = $request->validate([
            "password" => 'required | confirmed | max:50',
        ]);

        $this->service->update($link, $data['password']);
        return redirect(route('restore_password.show'))->with('password_restored', true);
    }

    public function show()
    {
        return view('success.password_restored');
    }
}


