<?php

namespace App\Http\Controllers\Form;

use Illuminate\Http\Request;
use App\Http\Controllers\Form\BaseController;
use App\Models\QuestionTypes;

class CreateController extends BaseController
{
    public function store(Request $request)
    {
        $form = $request['form'];

        // validate questions
        $questions = $this->validate_questions($form['questions']);
        if ($questions === 'error') return false;

        // upload form
        $form_id = $this->service->upload_form($form['name']);
        $this->service->upload_questions($form_id, $questions);

        return 'form created';
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
        $types = [];
        foreach(QuestionTypes::get() as $type) {
            $types[] = ['id' => $type->id, 'type' => $type->type];
        }

        foreach($questions as $key => $question) {
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

        if (count($questions) === 0) return 'error';
        return $questions;
    }
}
