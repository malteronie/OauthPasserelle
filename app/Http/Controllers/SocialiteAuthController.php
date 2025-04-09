<?php

namespace App\Http\Controllers;

use App\Events\NewSocialiteUserEvent;
use App\Models\AccessToken;
use App\Models\Client;
use App\Models\User;
use Arr;
use Exception;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteAuthController extends Controller
{
    public function redirect(Request $request) {
        $redirectUri = $request->query('redirect_uri', url('/'));
        // Stocker l'URI de redirection en session
        session(['redirect_uri' => $redirectUri]);
        // dd(session('redirect_uri'));
        /** @var \Laravel\Socialite\Two\GoogleProvider  */
        $driver = Socialite::driver('passport');

        return $driver->with(['prompt' => 'login'])->redirect();
    }

    public function authenticate(Request $request)
    {
        // dd(session(), $request);
        $userSocialite = Socialite::driver('passport')->user();
        $user = User::firstOrCreate([
            'email' => $userSocialite->getEmail(),
        ], [
            'name' => $userSocialite->getName(),
            'password' => bcrypt('password'),
            'login' => $userSocialite->getName(),
        ]);
        AccessToken::where('user_id', '=', $user->id)->delete();
        // Générer un token Passport pour App 2
        $token = $user->createToken('App2Token')->accessToken;
        $user->remember_token = $token;
        $user->save();
        // Récupérer redirect_uri depuis la session
        $redirectUri = session('redirect_uri', url('/'));
        session()->forget('redirect_uri'); // Nettoyer la session après redirection
    
        return redirect("{$redirectUri}?token={$token}");
    }


    public function changeParams(Request $request)
    {
        // dd($request);
        
        $path = base_path('.env');

        if (!file_exists($path)) {
            return response()->json(['error' => 'Fichier .env introuvable'], 500);
        }
        $newValues = [];
        foreach ($request->input() as $key=>$value) {
            if($key!='_token'){
                $newValues[$key] = $value;
            }
        }

        foreach ($newValues as $param => $newValue) {
        if ($newValue === null) {
            return response()->json(['error' => 'Valeur invalide'], 400);
        }

        $envContent = file_get_contents($path);
        if (preg_match('/^' . preg_quote($param, '/') . '=(.*)$/m', $envContent)) {

            $envContent = preg_replace(
                '/^' . preg_quote($param, '/') . '=.*/m',
                $param . '=' . $newValue,
                $envContent
            );
        } else {
            $envContent .= "\n" . $param . '=' . $newValue . "\n";
        }

        file_put_contents($path, $envContent);
    }

        Artisan::call('config:clear');

        return to_route('param.proxy');
    }

    public function destroyClient($id) {
        $client = Client::find($id);
        $client->delete();
        // dd($client);
        return to_route('dashboard.clients');
    }
}