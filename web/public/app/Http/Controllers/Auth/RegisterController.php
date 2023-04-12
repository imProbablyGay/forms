<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
       // $data = $request->validated();
       $data=$request;
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password']),
        ]);

        if ($user) {
            auth('web')->login($user);
        }
        else {
            dd($data);
        }

        return redirect(route('login.index'));
    }

    public function index(Request $request)
    {
        $post = $request->all();
        return view('auth.register', compact('post'));
    }
}


