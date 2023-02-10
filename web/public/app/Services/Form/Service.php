<?php
namespace App\Services\Form;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Forms;
use App\Models\Questions;
use App\Models\Options;

class Service
{
    public function upload_form($name)
    {
        $form = new Forms;
        $form->user_id = Auth::id();
        $form->name = $name;
        $form->save();
        return $form->id;
    }

    public function upload_questions($form_id, $questions)
    {
        foreach($questions as $q) {
            $question = new Questions;
            $question->form_id = $form_id;
            $question->text = $q['title'];
            $question->is_required = $q['required'];
            $question->type = $q['type'];
            $question->save();

            $this->upload_options($question->id, $q['options']);
        }
    }

    public function upload_options($q_id, $options)
    {
        foreach($options as $o) {
            $option = new Options;
            $option->q_id = $q_id;
            print_r($o);
            if (is_array($o)) {
                $option->another = $o['another_option'];
            }
            else {
                $option->value = $o;
            }
            $option->save();
        }
    }
}

