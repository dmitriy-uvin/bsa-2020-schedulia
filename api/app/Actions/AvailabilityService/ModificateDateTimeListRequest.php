<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

use App\Entity\EventType;

final class ModificateDateTimeListRequest
{
    private array $dateTimeList;
    private ?EventType $eventType;

    public function __construct(array $dateTimeList, ?EventType $eventType = null)
    {
        $this->dateTimeList = $dateTimeList;
        $this->eventType = $eventType;
    }

    public function getDateTimeList(): array
    {
        return $this->dateTimeList;
    }

    public function getEventType(): ?EventType
    {
        return $this->eventType;
    }
}
