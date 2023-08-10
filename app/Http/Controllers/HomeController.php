<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        /**
         * @var array<string> $request
         */
        Mail::send(new ContactMail($request));

        return to_route('dashboard');
    }
}
