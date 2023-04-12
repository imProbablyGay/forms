<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $field_type = filter_var($data['name'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $remember = $request->has('remember') ? true : false;
        $login_data = [
            $field_type => $data['name'],
            'password' => $data['password'],
        ];

        if(auth()->attempt($login_data, $remember)) {
            return redirect(route('profile.index'));
        }

        return redirect(route('login.index'))->with('wrong_data', 'Неправильный e-mail/имя пользователя или пароль');
    }
}

