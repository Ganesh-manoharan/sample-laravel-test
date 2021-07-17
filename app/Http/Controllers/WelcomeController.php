<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // to do
    }

    public function landing()
    {
        return view('landing');
    }
    public function translate(Request $request)
    {
        return redirect()->back()->withCookie(cookie('locale', $request->lang, 500000));
    }
}
