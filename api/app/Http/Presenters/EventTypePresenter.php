<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use App\Entity\EventType;
use Illuminate\Support\Collection;

final class EventTypePresenter implements PresenterCollectionInterface
{
    private UserArrayPresenter $userPresenter;
    private AvailabilityArrayPresenter $availabilityPresenter;

    public function __construct(UserArrayPresenter $userPresenter, AvailabilityArrayPresenter $availabilityPresenter)
    {
        $this->userPresenter = $userPresenter;
        $this->availabilityPresenter = $availabilityPresenter;
    }

    public function presentCollection(Collection $eventTypeCollection): array
    {
        return $eventTypeCollection->map(function ($eventType) {
            return $this->present($eventType);
        })->toArray();
    }

    public function present(EventType $eventType): array
    {
        return [
            'id' => $eventType->id,
            'name' => $eventType->name,
            'description' => $eventType->description,
            'internal_note' => $eventType->internal_note,
            'slug' => $eventType->slug,
            'color' => $eventType->color,
            'duration' => $eventType->duration,
            'disabled' => $eventType->disabled,
            'timezone' => $eventType->timezone,
            'owner' => $this->userPresenter->present($eventType->owner),
            'availabilities' => $eventType->availabilities()->get()->map(function ($availability) {
                return $this->availabilityPresenter->present($availability);
            }),
        ];
    }
}
