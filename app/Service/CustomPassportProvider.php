<?php

namespace App\Service;

use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use Laravel\Socialite\Two\AbstractProvider;

class CustomPassportProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopeSeparator = ' ';
    protected $stateless = true;
    /**
     * URL d'authentification OAuth
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(env('URL_SERVER').'/oauth/authorize', $state);
    }
    
    /**
     * URL pour récupérer le token
     */
    protected function getTokenUrl()
    {
        return (env('URL_SERVER').'/oauth/token');
    }

    /**
     * URL pour récupérer les informations de l'utilisateur
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(env('URL_SERVER').'/api/user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Transformer la réponse API en objet User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ]);
    }

    /**
     * Retourne les paramètres envoyés pour récupérer le token
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);
    }
}