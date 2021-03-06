<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterInterface;
use App\Entity\User;

final class UserArrayPresenter implements PresenterInterface
{
    public function present(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'timezone' => $user->getTimezone(),
            'avatar' => $user->getAvatarUrl(),
            'branding_logo' => $user->getBrandingLogoUrl(),
            'welcome_message' => $user->welcome_message,
            'language' => $user->language,
            'date_format' => $user->date_format,
            'time_format_12h' => $user->time_format_12h,
            'country' => $user->country,
            'nickname' => $user->nickname,
            'slack_webhook' => $user->slack_webhook,
            'slack_channel' => $user->slack_channel,
            'slack_active' => $user->slack_active,
            'chatito_active' => $user->chatito_active,
            'zoom_active' => $user->zoom_active,
            'whale_active' => $user->whale_active
        ];
    }
}
