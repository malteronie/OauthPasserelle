<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * 
     */
    public function contact(Request $request) : RedirectResponse
    {
        Mail::send(new ContactMail($request));

        return to_route('dashboard');
    }
}
