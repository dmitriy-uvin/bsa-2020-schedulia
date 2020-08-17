<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Entity\EventType;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EventTypeRepository extends BaseRepository implements EventTypeRepositoryInterface
{
    public function getById(int $id): ?EventType
    {
        return EventType::find($id);
    }

    public function getByString(?string $searchString): ?Collection
    {
        return EventType::where('name', 'like', $searchString . '%')->get();
    }

    public function save(EventType $eventType): EventType
    {
        $eventType->save();

        return $eventType;
    }

    public function deleteById(int $id): void
    {
        EventType::destroy($id);
    }

    public function getEventTypesByOwnerId(int $id): Collection
    {
        return EventType::where('owner_id', $id)->get();
    }

    public function saveAvailabilities(EventType $eventType, array $availabilities): void
    {
        $eventType
            ->availabilities()
            ->createMany($availabilities);
    }

    public function deleteAvailabilities(EventType $eventType): void
    {
        $eventType
            ->availabilities()
            ->delete();
    }
}
