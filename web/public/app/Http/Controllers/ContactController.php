<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactForm;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show_contact_form()
    {
        return view('contact_form');
    }

    public function contact_form_process(ContactFormRequest $request)
    {
        Mail::to('temadoron9@gmail.com')->send(new ContactForm($request->validated()));

        return redirect(route('show_contact_form'))->with([
            'sent' => true
        ]);
    }
}
