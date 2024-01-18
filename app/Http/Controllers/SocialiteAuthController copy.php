<?php

namespace App\Http\Controllers;

use App\Events\NewSocialiteUserEvent;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteAuthController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function authenticate()
    {
        $password = Str::password(12);
        try {

            /**
             * @var \SocialiteProviders\Manager\OAuth2\User $socialiteUser
             */
            $socialiteUser = Socialite::driver('keycloak')->user();

            $existuser = User::where('email', $socialiteUser->email)->first();

            if ($existuser == null) {
                $user = User::updateOrCreate(
                    ['email' => strtolower($socialiteUser->getEmail())],
                    ['short_rank' => $socialiteUser->short_rank,
                        'rank' => $socialiteUser->rank,
                        'name' => $socialiteUser->getName(),
                        'first_name' => $socialiteUser->user['given_name'],
                        'last_name' => $socialiteUser->user['family_name'],
                        'login' => $socialiteUser->domain_login,
                        'affectation_annudef' => $socialiteUser->main_department_number,
                        'password' => Hash::make($password), ]);

                event(new NewSocialiteUserEvent($user->toArray(), $password));
            } else {
                $user = User::updateOrCreate(
                    ['email' => strtolower($socialiteUser->getEmail())],
                    ['short_rank' => $socialiteUser->short_rank,
                        'rank' => $socialiteUser->rank,
                        'name' => $socialiteUser->getName(),
                        'first_name' => $socialiteUser->user['given_name'],
                        'last_name' => $socialiteUser->user['family_name'],
                        'login' => $socialiteUser->domain_login,
                        'affectation_annudef' => $socialiteUser->main_department_number, ]
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
