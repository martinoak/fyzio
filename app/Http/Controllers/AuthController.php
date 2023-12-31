<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        if (Auth::attempt($request->only('name', 'password'))) {
            return to_route('admin.dashboard')->with('success', 'Přihlášení proběhlo úspěšně');
        } else {
            return back()->with('error', 'Nesprávné přihlašovací údaje')->withInput();
        }
    }
}
