<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Forms;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_form_id_from_hash($form_hash)
    {
        $form = Forms::where('hash','=',$form_hash)->get('id');
        if (count($form) === 0) return false;

        return $form[0]['id'];
    }
}
