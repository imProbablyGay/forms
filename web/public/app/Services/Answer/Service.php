<?php
namespace App\Services\Answer;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Forms;
use App\Models\Questions;
use App\Models\Options;
use App\Models\QuestionTypes;
use App\Models\Answers;
use App\Models\AnswersOptions;

class Service
{
    public function get_form_user($form_id)
    {
        // get user name and user id
        $form = Forms::find($form_id);

        // if form doesnt exist or is deleted
        if (!$form || $form->deleted) return false;

        return [
            'user_id' => $form->user_id,
            'user_name' => User::find($form->user_id)->name,
        ];
    }


    public function get_form($id, $q_limit, $offset = 0) {
        // get form by id in url
        $form = Forms::find($id);

        // get questions
        $questions = $form->questions->skip($offset)->take($q_limit);

        foreach($questions as $key => $question) {
            // set type in text format
            $questions[$key]['type'] = QuestionTypes::find($question['type'])->type;

            // get options
            $options = $question->options->toArray();
            $questions[$key]['options'] = $options;
        }

        //return answer in json
        return json_encode([
            'title' => $form->name,
            'questions' => $questions->toArray(),
        ]);
    }

    // upload new answer
    public function validate_answers($form_id, $questions)
    {
        $form= Forms::find($form_id);

        // check if form is deleted
        if (!$form || $form->deleted) return false;

        $form_questions = $form->questions;
        $success = true;

        foreach($questions as $index => $question) {
            // validate question type and id
            if (!$this->validate_question($form_questions[$index], $question)) {
                $success = false;
                break;
            }

            // if question is not empty
            if (!empty($question['options'])) {
                if (!$this->validate_option($form_questions[$index], $question)) {
                    $success = false;
                    break;
                }
            }
            // if question is empty
            else {
                // if question is required
                if ($form_questions[$index]->is_required) {
                    $success = false;
                }
            }
        }

        if ($success === false) return false;
        return true;
    }

    private function validate_option($form_question, $question)
    {
        // if NULL
        // check if there is only one null option
        $o_count = count($question['options']);
        if ($o_count > 1 && $question['options'][$o_count-1]['o_id'] === NULL) return false;
        // if Null option, dont validate id and type
        if ($question['options'][0]['o_id'] === NULL) {
            return true;
        }

        // validate radio and checkbox option
        if ($question['type'] === 'radio' || $question['type'] == 'checkbox') {
            foreach($question['options'] as $option) {
                $o_id = $this->validate_option_id($form_question, $option['o_id']);
                if (!$o_id) {
                    return false;
                }

                // check value if another option
                if ($o_id->another && $option['value'] == '') {
                    return false;
                }
            }
        }
        // validate text option
        else if ($question['type'] === 'text') {
            $o_id = $this->validate_option_id($form_question, $question['options'][0]['o_id']);
            if (!$o_id || !$question['options'][0]['value']) {
                return false;
            }
        }

        return true;
    }

    private function validate_option_id($form_question, $option_id)
    {
        $o_id = Options::find($option_id); //find option by option id
        if (!$o_id) {
            return false;
        }
        // check option id
        $q_id = $o_id->question->id;
        if ($q_id != $form_question->id) {
            return false;
        }

        return $o_id;
    }

    private function validate_question($form_question, $question)
    {
        // validate question id and question type
        if ($form_question->id != $question['q_id']) {
            return false;
        }
        else if (QuestionTypes::find($form_question->type)->type != $question['type']) {
            return false;
        }

        return true;
    }

    public function upload_answer($form_id, $questions)
    {
        // create answer block
        $answer_block = new Answers;
        $answer_block->user_id = Auth::id();
        $answer_block->form_id = $form_id;
        $answer_block->save();
        $a_id = $answer_block->id;

        // create answers options
        foreach($questions as $question) {
            foreach($question['options'] as $option) {
                $a_option = new AnswersOptions;
                $a_option->answer_id = $a_id;
                $a_option->option_id = $option['o_id'];
                $a_option->question_id = $question['q_id'];
                $a_option->text = $option['value'];
                $a_option->save();
            }
        }

        //return uploaded answer id
        return $answer_block->id;
    }
    // end upload new answer
}

