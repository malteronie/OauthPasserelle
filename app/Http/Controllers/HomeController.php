<?php

namespace App\Http\Controllers;

use App\Events\ContactMailEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        event(new ContactMailEvent($request->toArray()));

        return to_route('dashboard');
    }
}
