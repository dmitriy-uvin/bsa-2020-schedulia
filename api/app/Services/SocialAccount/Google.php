<?php

namespace App\Services\SocialAccount;

use App\Entity\SocialAccount;
use App\Entity\User;
use App\Exceptions\GoogleOauthException;
use App\Exceptions\SocialAccount\SocialAccountNotFoundException;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Contracts\CalendarEventInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Calendar\Google\GoogleCalendarEventPresenter;
use Illuminate\Config\Repository;
use App\Contracts\CalendarService;
use App\Contracts\SocialAccountService;
use Illuminate\Support\Facades\Auth;

class Google implements SocialAccountService, CalendarService
{
    protected $client;
    private Repository $config;
    private SocialAccountRepositoryInterface $socialAccountRepository;
    private UserRepositoryInterface $userRepository;
    private GoogleCalendarEventPresenter $googleCalendarEventPresenter;

    public function __construct(
        Repository $config,
        SocialAccountRepositoryInterface $socialAccountRepository,
        UserRepositoryInterface $userRepository,
        GoogleCalendarEventPresenter $googleCalendarEventPresenter
    ) {
        $this->config = $config;
        $this->client = $this->setupClient();
        $this->userRepository = $userRepository;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->googleCalendarEventPresenter = $googleCalendarEventPresenter;
    }

    public function __call(string $method, array $args)
    {
        if (!method_exists($this->client, $method)) {
            throw new \Exception("Call to undefined method '{$method}'");
        }

        return call_user_func_array([$this->client, $method], $args);
    }

    public function service(string $service)
    {
        $classname = 'Google_Service_' . $service;

        return new $classname($this->client);
    }

    public function auth(string $code = null, string $state = null)
    {
        if (!$code) {
            return $this->createAuthUrl();
        } else {
            $this->authenticate($code);
            $user = $this->decodeUser($state);

            $token = $this->getAccessToken();

            if (!$token) {
                throw new GoogleOauthException();
            }

            $socialAccount = $this->socialAccountRepository->findByProvider(
                SocialAccount::GOOGLE_SERVICE_ID,
                $user->userId
            );

            $socialAccount->account_id = $user->userId;
            $socialAccount->token = $token;
            $socialAccount->refresh_token = $token['refresh_token'];
            $socialAccount->expires_in = '2020-08-27 22:57:59';

            $socialAccount->save();

            return $this->config->get('services.google.frontend_redirect_uri');
        }
    }

    public function delete(int $userId): void
    {
        $socialAccount = $this->socialAccountRepository->findByProvider(
            SocialAccount::GOOGLE_SERVICE_ID,
            $userId
        );

        if (!$socialAccount) {
            throw new SocialAccountNotFoundException();
        }

        $this->revokeToken($socialAccount->token);
        $socialAccount->delete();
    }

    public function connect($token): Google
    {
        $this->client->setAccessToken($token);

        return $this;
    }

    private function revokeToken($token = null)
    {
        $token = $token ?? $this->client->getAccesToken();

        return $this->client->revokeToken($token);
    }

    public function createEvent(CalendarEventInterface $googleCalendarEvent): void
    {

        $token = $this->userRepository->getGoogleCalendarTokenById($googleCalendarEvent->getUserId());

        if ($token) {
            $event = new \Google_Service_Calendar_Event($this->googleCalendarEventPresenter->present($googleCalendarEvent));
            $this->connect($token)->service('Calendar')->events->insert('primary', $event);
        }
    }

    public function deleteEvent(): void
    {
        // TODO: Implement deleteEvent() method.
    }

    private function setupClient(): \Google_Client
    {
        $options = $this->config->get('services.google');

        $client = new \Google_Client();
        $client->setClientId($options['client_id']);
        $client->setClientSecret($options['client_secret']);
        $client->setRedirectUri($options['calendar_redirect_uri']);
        $client->setScopes($options['scopes']);
        $client->setApprovalPrompt($options['approval_prompt']);
        $client->setAccessType($options['access_type']);
        $client->setState($this->encodeUser());

        return $client;
    }

    private function encodeUser()
    {
        return base64_encode(json_encode(['userId' => Auth::id()]));
    }

    private function decodeUser($state)
    {
        return json_decode(base64_decode($state));
    }
}
