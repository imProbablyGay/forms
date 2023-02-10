<?php
namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class EditPictureController extends Controller
{
    public function update(Request $request)
    {
        $file = base64_decode($request['image']);
        $name = auth()->user()->id.'.jpeg';
        file_put_contents(public_path().'/img/users/icons/'.$name, $file);
    }
}
