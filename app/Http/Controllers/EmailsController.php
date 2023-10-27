<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMail;
use App\Mail\ContactFormMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    public function sendMail(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        Mail::to('martin.dub@dek-cz.com')->send(new ContactFormMail($request->all()));
        Mail::to($request->get('email'))->send(new ConfirmationMail($request->all()));

        return back()->with('success', 'Email odeslán!');
    }
}
