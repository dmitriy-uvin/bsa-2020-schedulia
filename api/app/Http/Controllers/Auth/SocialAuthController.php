<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SocialAuthAction;
use App\Http\Controllers\Api\ApiController;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends ApiController
{
    private SocialAuthAction $action;

    public function __construct(
        SocialAuthAction $action
    ) {
        $this->action = $action;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $response = $this->action->execute($provider);

        return redirect(env('CLIENT_APP_URL') . '/auth/social-callback?token=' . $response);
    }
}
