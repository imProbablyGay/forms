<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForgotPasswordController extends BaseController
{
    public function index()
    {
        return view('auth.forgot_password');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required | email | exists:users'
        ],
        [
            "email.exists" => 'Такой email не зарегестрирован'
        ]
        );

        $this->service->store($data['email']);

        return redirect(route('forgot_password.index'))->with('success', 'На вашу почту былa отправлена инструкция по восстановлению пароля.');
    }
}


