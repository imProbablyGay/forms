<?php
// 12
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Models\RestorePasswords;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function show_login_form()
    {
        return view('auth.login');
    }

    public function login_process(Request $request)
    {
        $data = $request->validate([
            "name" => 'required | max:200',
            "password" => 'required | max:50',
        ]);

        if(auth('web')->attempt($data)) {
            return redirect(route('login'));
        }

        return redirect(route('login'))->with('data', 'wrong data');
    }

    public function register_process(AuthRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password']),
        ]);

        if ($user) {
            auth('web')->login($user);
        }

        return redirect(route('login'));
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect(route('login'));
    }

    public function show_register_form()
    {
        return view('auth.register');
    }

    public function show_forgot_password()
    {
        return view('auth.forgot_password');
    }

    public function forgot_password_process(Request $request)
    {
        $data = $request->validate([
            'email' => 'required | email | string | exists:users'
        ]);

        $user = User::where('email', $data['email'])->first();
        $restore_link = uniqid();
        $this->restore_password_db($user->id, $restore_link); //save data to restore_passwords table
        $link = route('show_restore_password', $restore_link);
        $user->save();

        Mail::to($user)->send(new ForgotPassword($link));

        return redirect(route('show_forgot_password'))->with('success', 'На вашу почту было отправлено письмо по восстановлению пароля.');
    }

    private function restore_password_db($id, $link) {
        $restore = new RestorePasswords;
        $restore->user_id = $id;
        $restore->time = Carbon::now()->timestamp;
        $restore->link = $link;
        $restore->save();
    }

    public function show_restore_password($link)
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

    public function restore_password_process($link, Request $request)
    {
        $data = $request->validate([
            "password" => 'required | confirmed | max:50',
        ]);

        // get user id
        $user = RestorePasswords::where('link', '=', $link)->first();
        if (!$user) return redirect(route('not_found'));
        $user_id = $user->user_id;

        // update password
        $user = User::where('id', '=', $user_id)->first();
        $user->password = bcrypt($data['password']);
        $user->save();

        // delete data from restore_passwords table
        $restore = RestorePasswords::where('user_id','=',$user_id)->delete();

        return redirect(route('show_restored_password'))->with('password_restored', true);
    }

    public function show_restored_password()
    {
        return view('success.password_restored');
    }

    public function show_profile_edit()
    {
        return view('auth.edit', ['user' => auth()->user()]);
    }

    public function edit_profile_picture_process(Request $request)
    {
        $file = base64_decode($request['image']);
        $name = auth()->user()->id.'.jpeg';
        $success = file_put_contents(public_path().'/img/'.$name, $file);
        return $success;
    }

    public function edit_profile_process(Request $request)
    {
        $exists = $this->validate_edit_data($request['name'], $request['email']);
        if ($exists) return $exists;

        $data = $request->validate([
            'name' => 'required | max:200',
            'email' => 'required | email | max:100',
            'password' => 'nullable | max:50'
        ]);

        $user = User::find(auth()->user()->id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        if ($request['password'] != NULL && trim($request['password'] != '')) {
            $user->password = bcrypt($request['password']);
        }
        $user->save();

        return 'success';
    }

    private function validate_edit_data($name, $email)
    {
        $name = User::where('name', '=', $name)->first();
        if ($name && $name->id != auth()->user()->id) return 'такое имя уже есть';

        $email = User::where('email', '=', $email)->first();
        if ($email && $email->id != auth()->user()->id) return 'такой email уже есть';
    }
}




// public function about() {
//     $data = $this->display_all();
//     return view('about', ['data' => $data])->with('success', 'sdfsddf');
// }

// public function form(Request $request) {
//     $user = new Contact();
//     $user->name = $request->input('name');

//     $user->save();
//     return redirect('/about');
// }

// private function display_all() {
//     $user = new Contact();
//     return $user->all();
// }

// public function delete($id, Request $request) {
//     Contact::find($id)->delete();

//     return redirect('/about')->with('success', 'message deleted');
// }

// public function update($id, Request $request) {
//     $user = Contact::find($id);
//     $user->name = $request->input('name');
//     $user->save();

//     return redirect('/about')->with('success', 'message updated');
// }
