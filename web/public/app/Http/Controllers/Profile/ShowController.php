<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Profile\BaseController;
use Illuminate\Http\Request;
use App\Models\Forms;
use App\Models\User;
use App\Models\Answers;

class ShowController extends BaseController
{

    public function index()
    {
        $forms_count = User::find(auth()->user()->id)->forms->where('deleted','=',false)->count();
        return view('profile.show', compact('forms_count'));
    }

    public function get_answers_description(Request $request)
    {
        return $this->service->get_answers_description(auth()->user()->id, $request['limit'], $request['offset']);
    }

    public function show_form($form_hash)
    {
        // check if form exists and is not deleted
        $form_id = $this->get_form_id_from_hash($form_hash);
        $form = Forms::find($form_id);
        if (!$form || $form->deleted) return redirect(route('not_found'));

        $answers_amount = Answers::where('form_id','=',$form_id)->count(); //amount of answers on current form
        $copy_link = route('answer_form.index', ['form_hash'=>$form_hash]); // copy link for users
        return view('profile.show_form', compact('answers_amount', 'copy_link'));
    }

    function get_profile_form_statistics($form_hash, Request $request)
    {
        $form_id = $this->get_form_id_from_hash($form_hash);
        return $this->service->get_profile_form_statistics($form_id, $request['q_limit'], $request['offset']);
    }

    function get_profile_form_certain_answer($form_hash, $a_id, Request $request)
    {
        $form_id = $this->get_form_id_from_hash($form_hash);
        return $this->service->get_profile_form_certain_answer($form_id, $a_id, $request['q_limit'], $request['offset']);
    }

    function get_option_text($option_id,Request $request)
    {
        return $this->service->get_option_text($option_id, $request['offset']);
    }
}
