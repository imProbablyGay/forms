<?php
namespace App\Services\Profile;

use App\Models\User;
use App\Models\Answers;
use App\Models\Forms;
use App\Models\AnswersOptions;
use App\Models\QuestionTypes;

use App\Http\Controllers\Answer\Controller as AnswersController;

class Service
{
    const TEXT_VALUES_LIMIT = 4;

    function update($data)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if ($data['password'] != NULL && trim($data['password'] != '')) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
    }

    function validate_edit_data($name, $email)
    {
        $name = User::where('name', '=', $name)->first();
        if ($name && $name->id != auth()->user()->id) return 'такое имя уже есть';

        $email = User::where('email', '=', $email)->first();
        if ($email && $email->id != auth()->user()->id) return 'такой email уже есть';
    }

    //get answers description in profile
    public function get_answers_description($user_id, $a_limit, $offset = 0)
    {
        // get forms uploaded by current user
        $user = User::find($user_id);
        $forms_object = Forms::where('deleted','=',false)
        ->where('user_id', '=', $user_id)
        ->orderBy('id', 'desc')
        ->skip($offset)
        ->take($a_limit)
        ->get()
        ->toArray();

        // get answers count for each form
        $output = [];
        $i = 0;
        foreach($forms_object as $form) {
            $output[] = $form;
            $output[$i]['answers_count'] = AnswersController::get_count($form['id']);

            $i++;
        }

        return $output;
    }

    // get answers in profile page(with counts of options and answers)
    public function get_profile_form_statistics($form_id, $q_limit, $offset = 0) {
        // get form by id in url
        $form = Forms::find($form_id);

        // get questions
        $questions = $form->questions->skip($offset)->take($q_limit);
        $output_questions = [];

        foreach($questions as $key => $question) {
            // set amount of filled answers on this questions
            $question_answers_amount = AnswersOptions::groupBy('answer_id')
            ->where('question_id','=',$question['id'])
            ->whereNotNull('option_id')
            ->get()
            ->count();
            $output_questions[$key]['answers_amount'] = $question_answers_amount;

            // set type in text format
            $output_questions[$key]['type'] = QuestionTypes::find($question['type'])->type;

            // set text
            $output_questions[$key]['text'] = $question->text;

            // get options
            $options = $question->options->toArray();

            // set amount of how many time this option has been choosen
            foreach($options as $key_2 => $option) {
                $options[$key_2]['amount'] = AnswersOptions::where('option_id','=',$option['id'])->count();
                $options[$key_2]['total'] = AnswersOptions::groupBy('answer_id')->where('question_id','=',$question['id'])->whereNotNull('option_id')->get()->count();
                $options[$key_2]['text'] = $this->get_option_text($option['id']);
            }
            $output_questions[$key]['options'] = $options;
        }

        //return answer in json
        return json_encode([
            'title' => $form->name,
            'questions' => $output_questions,
        ]);
    }

    public function get_profile_form_certain_answer($form_id, $a_id, $q_limit, $offset = 0)
    {
        // get form by id in url
        $form = Forms::find($form_id);

        // get questions
        $questions = $form->questions->skip($offset)->take($q_limit);
        $output_questions = [];

        // check if answer id is bigger than it can be
        $max_a_id = AnswersController::get_count($form['id']);
        if ($a_id > $max_a_id) $a_id = $max_a_id;

        // get current answer id
        $answer = $form->answers
        ->skip($a_id - 1)
        ->first();
        if (!$answer) return ['error' => 'no answers'];

        foreach($questions as $key => $question) {
            // set type in text format
            $output_questions[$key]['type'] = QuestionTypes::find($question['type'])->type;

            // set text
            $output_questions[$key]['text'] = $question->text;

            // get options
            $options = $question->options->toArray();
            foreach($options as $key_2 => $option) {
                // get answer choosed option(and text) on current sent answer
                $choosed_option_values = $this->get_certain_option_values($answer->id, $option['id']);
                // set choosed option, if not NULL is default
                $options[$key_2]['data'] = $choosed_option_values;
            }
            $output_questions[$key]['options'] = $options;
        }

        //return answer in json
        return json_encode([
            'title' => $form->name,
            'date' => $answer->created_at->format('d.m.Y H:i'),
            'questions' => $output_questions,
        ]);
    }

    // get options text, which was answered by user
    public function get_option_text($o_id, $offset = 0, $limit = self::TEXT_VALUES_LIMIT)
    {
        return AnswersOptions::
        where('option_id','=',$o_id)
        ->whereNotNull('text')
        ->skip($offset)
        ->take($limit)
        ->get(['text']);
    }

    // get only one text value of certain question
    private function get_certain_option_values($a_id, $o_id)
    {
        $choosed = AnswersOptions::
        where('option_id','=',$o_id)
        ->where('answer_id','=',$a_id)
        ->get()
        ->toArray();

        if (!$choosed) return [];

        return [
            'choosed' => true,
            'text' => $choosed[0]['text']
        ];
    }
}

