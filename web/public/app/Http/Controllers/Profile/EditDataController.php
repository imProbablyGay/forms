<?php
namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Profile\BaseController;
use Illuminate\Http\Request;

class EditDataController extends BaseController
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $exists = $this->service->validate_edit_data($request['name'], $request['email']);
        if ($exists) return $exists;

        $data = $request->validate([
            'name' => 'required | max:200',
            'email' => 'required | email | max:100',
            'password' => 'nullable | max:50'
        ]);
        $this->service->update($data);

        return redirect(route('edit_profile_data.edit'))->with('success', 'Данные успешно изменены');
    }
}
