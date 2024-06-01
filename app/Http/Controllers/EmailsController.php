<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ConfirmationMail;
use App\Mail\ContactFormMail;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    public function sendMail(ContactFormRequest $request): RedirectResponse
    {
        if ($request->filled('_hpt')) {
            abort(403);
        }

        Mail::to('martin.dub@dek-cz.com')->send(new ContactFormMail($request->all()));
        Mail::to($request->input('email'))->send(new ConfirmationMail($request->all()));

        Customer::create($request->all());

        return back()->with('success', 'Email odeslán!');
    }
}
