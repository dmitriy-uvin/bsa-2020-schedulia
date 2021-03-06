<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Entity\SocialAccount;
use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

final class SocialAuthAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(SocialAuthRequest $request): SocialAuthResponse
    {
        $socialUser = Socialite::driver($request->getProvider())->stateless()->user();
        $user = $this->findOrCreateUser($request->getProvider(), $socialUser);

        $token = auth()->login($user);

        return new SocialAuthResponse($token);
    }

    private function findOrCreateUser($provider, $socialUser)
    {
        $socialAccount = $this->userRepository->getByAccountId($socialUser->getId());

        if ($socialAccount) {
            $socialAccount->update([
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken
            ]);

            return $socialAccount->user;
        }

        $user = $this->userRepository->getByEmail($socialUser->getEmail());

        if ($user) {
            return $user;
        }

        return $this->createUser($provider, $socialUser);
    }

    private function createUser($provider, $socialUser)
    {
        $user = new User();
        $user->name = $socialUser->getName();
        $user->nickname = strtolower(trim(str_replace(' ', '_', $socialUser->getName())));
        $user->email = $socialUser->getEmail();
        $user->email_verified_at = now();
        $user->password = Hash::make(Str::random(40));

        $user = $this->userRepository->save($user);

        $user->socialAccounts()->create([
            'user_id' => $user->getId(),
            'account_id' => $socialUser->getId(),
            'token' => $socialUser->token,
            'provider_id' => $this->setProviderId($provider),
            'refresh_token' => $socialUser->refreshToken,
            'expires_in' => $socialUser->expiresIn

        ]);

        return $user;
    }

    private function setProviderId($provider)
    {
        $providerId = 0;

        switch ($provider) {
            case 'google':
                $providerId = SocialAccount::GOOGLE_SERVICE_ID;
                break;
            case 'facebook':
               $providerId = SocialAccount::FACEBOOK_SERVICE_ID;
                break;
            case 'linkedin':
                $providerId = SocialAccount::LINKEDIN_SERVICE_ID;
        }

        return $providerId;
    }
}
