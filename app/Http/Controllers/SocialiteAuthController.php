<?php

namespace App\Http\Controllers;

use App\Mail\NewRegistrationMail;
use App\Mail\NewUserMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    public function authenticate()
    {
        $password = Str::password(12);
        try {
            $socialiteUser = Socialite::driver('keycloak')->user();

            $existuser = User::where('email', $socialiteUser->email)->first();

            if ($existuser == null) {
                $user = User::updateOrCreate(
                    ['email' => strtolower($socialiteUser->getEmail())],
                    ['short_rank' => 'TSEF2',
                        'rank' => 'Technicien blalalalala',
                        'name' => $socialiteUser->getName(),
                        'first_name' => $socialiteUser->user['given_name'],
                        'last_name' => $socialiteUser->user['family_name'],
                        'login' => 'jackjackjack',
                        'affectation_annudef' => 'ALAVIA',
                        'password' => Hash::make($password), ]);

                Mail::send(new NewUserMail(['email' => $user->email, 'name' => $user->name], $password));
                Mail::send(new NewRegistrationMail(['email' => $user->email, 'short_rank' => $user->short_rank, 'name' => $user->name, 'id' => $user->id]));
            } else {
                $user = User::updateOrCreate(
                    ['email' => strtolower($socialiteUser->getEmail())],
                    ['short_rank' => 'TSEF2',
                        'rank' => 'Technicien blalalalala',
                        'name' => $socialiteUser->getName(),
                        'first_name' => $socialiteUser->user['given_name'],
                        'last_name' => $socialiteUser->user['family_name'],
                        'login' => $socialiteUser->getName(),
                        'affectation_annudef' => 'ALAVIA', ]
                );
            }

            Auth::login($user);

            return to_route('dashboard');
        } catch (Exception $exception) {
            //dd($exception);

            return to_route('login');
        }
    }
}
