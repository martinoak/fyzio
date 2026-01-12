<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function index(): View
    {
        // Group prices by service_name
        $prices = Price::orderBy('order')->get()->groupBy('service_name');

        return view('homepage', compact('prices'));
    }
}
