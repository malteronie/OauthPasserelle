<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ReinitPwdMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ReinitPwdEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AuthenticationController extends Controller
{
    public function form(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['login' => ['required', 'string'], 'password' => ['required', 'string']]);

        return Auth::attempt($credentials) ? to_route('dashboard') : to_route('login');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return to_route('dashboard');
    }

    public function sendpwd(Request $request): RedirectResponse
    {
        $user = User::where('email', $request->validate(['email' => 'required']))->first();
 
        if ($user)
        {        
            $password = Str::password(12);
            $user->password = Hash::make($password);
            $user->save();
            
            event (new ReinitPwdEvent($request->email, $password));

        }

        return to_route('login')->with('info', 'Si votre email est connu dans notre base, vous recevrez un nouveau mot de passe');
    }

    public function forgotpwd(): View
    {
        return view('auth.forgotpwd');
    }
}
