<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            "name" => 'required | max:200',
            "password" => 'required | max:50',
        ]);

        $field_type = filter_var($data['name'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $remember = $request->has('remember') ? true : false;
        $login_data = [
            $field_type => $data['name'],
            'password' => $data['password'],
        ];

        if(auth()->attempt($login_data, $remember)) {
            return redirect(route('edit_profile.index'));
        }

        return redirect(route('login.index'))->with('data', 'wrong data');
    }
}

