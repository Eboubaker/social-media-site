<?php


namespace App\Models\Traits;


trait HasApiToken
{
    public function initializeHasApiToken()
    {
        if(empty($this->getAttribute('api_token')))
        {
            // it will be hashed later by the api guard
            $token = \Illuminate\Support\Str::random(80);
            if(config('auth.guards.api.hash'))
                $token = hash('sha256', $token);
            $this->setAttribute('api_token', $token);
        }
    }
}
