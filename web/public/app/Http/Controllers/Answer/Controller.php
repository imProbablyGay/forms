<?php

namespace App\Http\Controllers\Answer;

use Illuminate\Http\Request;
use App\Http\Controllers\Answer\BaseController;
use App\Models\Answers;
use App\Models\Forms;

use App\Mail\AnswerSent;

use App\Http\Controllers\Answer\Controller as AnswersController;
use App\Http\Controllers\NotificationController;


class Controller extends BaseController
{
    public function index($form_hash)
    {
        $form_id = $this->get_form_id_from_hash($form_hash);
        $description = $this->service->get_form_user($form_id);
        if (!$form_id || !$description) return redirect(route('not_found'));

        return view('form.answer', compact('description'));
    }

    public function get_form(Request $request, $form_hash)
    {
        $form_id = $this->get_form_id_from_hash($form_hash);
        return $this->service->get_form($form_id, $request['q_limit'], $request['offset']);
    }

    public function upload_answer(Request $request, $form_hash) {
        // get form id
        $form_id = $this->get_form_id_from_hash($form_hash);

        // validate and send new answer
        if (!$this->service->validate_answers($form_id, $request['questions'])) return ['error' => 'validation'];
        $a_id = $this->service->upload_answer($form_id, $request['questions']);

        // send email
        $answer_id = Answers::where('form_id','=',$form_id)->get()->count();
        $email = Forms::find($form_id)->user->email;
        $link = route('profile.show_form', $form_hash)."?answer=$answer_id";
        $amount = AnswersController::get_count($form_id);
        NotificationController::sendByEmail($email, new AnswerSent($link, $amount));

        return ['success' => 'uploaded'];
    }

    public static function get_count($form_id) {
        return Answers::where('form_id','=',$form_id)->get()->count();
    }
}
