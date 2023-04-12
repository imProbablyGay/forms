<?php

namespace App\Http\Controllers\Form;

use Illuminate\Http\Request;
use App\Http\Controllers\Form\BaseController;
use App\Models\Forms;

class Controller extends BaseController
{
    public function destroy($form_hash, Request $request)
    {
        $id = $this->get_form_id_from_hash($form_hash);
        $form = Forms::find($id);
        if (!$form) return false;

        $form->deleted = true;
        $form->save();

        return true;
    }
}
