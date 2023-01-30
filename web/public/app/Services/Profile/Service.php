<?php
namespace App\Services\Profile;

use App\Models\User;

class Service
{
    function update($data)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if ($data['password'] != NULL && trim($data['password'] != '')) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
    }

    function validate_edit_data($name, $email)
    {
        $name = User::where('name', '=', $name)->first();
        if ($name && $name->id != auth()->user()->id) return 'такое имя уже есть';

        $email = User::where('email', '=', $email)->first();
        if ($email && $email->id != auth()->user()->id) return 'такой email уже есть';
    }
}

