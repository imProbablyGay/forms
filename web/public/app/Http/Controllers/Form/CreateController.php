<?php

namespace App\Http\Controllers\Form;

use Illuminate\Http\Request;
use App\Http\Controllers\Form\BaseController;
use App\Models\QuestionTypes;

class CreateController extends BaseController
{
    const MAX_AMOUNT_OF_QUESTIONS = 100;
    const MAX_AMOUNT_OF_OPTIONS = 100;

    public function store(Request $request)
    {
        $data_form = $request['form'];

        // validate questions
        $questions = $this->validate_questions($data_form['questions']);
        if (!$questions) return false;

        // upload form
        $form = $this->service->upload_form($data_form['name']);
        $form_questions = $this->service->upload_questions($form['id'], $questions);

        // check errors
        if (!$form_questions) return ['success' => false];

        return ['success' => true, 'form_hash' => $form['hash'], 'sdf' => [$form]];
    }

    public function index()
    {
        return view('form.create');
    }

    public function create_image(Request $request)
    {
        $image = $request->file('file');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img/form'), $new_name);
        return json_encode(['location' => '/img/form/'.$new_name]);
    }

    // check if question types are modified by user
    private function validate_questions($questions) {
        $types = QuestionTypes::get()->toArray();

        foreach($questions as $key => $question) {
            // check amount of options in each question
            if (count($question['options']) > self::MAX_AMOUNT_OF_OPTIONS) return false;

            // check valid type
            $valid = false;
            foreach($types as $type) {
                if ($question['type'] === $type['type']) {
                    $questions[$key]['type'] = $type['id'];
                    $valid = true;
                    break;
                }
            }
            if (!$valid) unset($questions[$key]);
        }

        if (count($questions) === 0 || count($questions) > self::MAX_AMOUNT_OF_QUESTIONS) return false;
        return $questions;
    }

    // get max values of form(amount of questions and amount of options)
    public function get_max_values()
    {
        return [
            'questions' =>self::MAX_AMOUNT_OF_QUESTIONS,
            'options' => self::MAX_AMOUNT_OF_OPTIONS,
        ];
    }
}
