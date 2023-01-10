<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Forms;
use App\Models\Questions;
use App\Models\Options;

class FormsController extends Controller
{
    public function upload_process(Request $request)
    {
        if (!Auth::check()) return 'u must be logged in';
        else {
            $form = $request['form'];
            $form_id = $this->upload_form($form['name']);
            $this->upload_questions($form_id, $form['questions']);

            return 'form created';
        }
    }


    private function upload_form($name)
    {
        $form = new Forms;
        $form->user_id = Auth::id();
        $form->name = $name;
        $form->save();
        return $form->id;
    }

    private function upload_questions($form_id, $questions)
    {
        foreach($questions as $q) {
            $question = new Questions;
            $question->form_id = $form_id;
            $question->text = $q['text'];
            $question->is_required = $q['is_required'];
            $question->type = $q['type'];
            $question->save();

            $this->upload_options($question->id, $q['options']);
        }
    }

    private function upload_options($q_id, $options)
    {
        foreach($options as $o) {
            $option = new Options;
            $option->q_id = $q_id;
            $option->value = $o['value'];
            $option->save();
        }
    }
}
