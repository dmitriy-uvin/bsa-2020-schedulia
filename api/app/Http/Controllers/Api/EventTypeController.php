<?php

namespace App\Http\Controllers\Api;

use App\Actions\EventType\AddEventTypeAction;
use App\Actions\EventType\AddEventTypeRequest;
use App\Actions\EventType\ChangeDisabledByIdAction;
use App\Actions\EventType\ChangeDisabledByIdRequest;
use App\Actions\EventType\DeleteEventTypeAction;
use App\Actions\EventType\DeleteEventTypeRequest;
use App\Actions\EventType\GetEventTypeByIdAction;
use App\Actions\EventType\GetEventTypeCollectionAction;
use App\Actions\EventType\GetEventTypeCollectionRequest;
use App\Actions\EventType\UpdateEventTypeAction;
use App\Actions\EventType\UpdateEventTypeRequest;
use App\Actions\GetByIdRequest;
use App\Http\Presenters\EventTypePresenter;
use App\Http\Requests\Api\EventType\ChangeDisabledEventTypeRequest;
use App\Http\Requests\Api\EventType\EventTypeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventTypeController extends ApiController
{
    private EventTypePresenter $eventTypePresenter;

    public function __construct(EventTypePresenter $eventTypePresenter)
    {
        $this->eventTypePresenter = $eventTypePresenter;
    }

    public function index(Request $request, GetEventTypeCollectionAction $action)
    {
        $response = $action->execute(
            new GetEventTypeCollectionRequest($request->searchString)
        )->getEventTypeCollection();

        return $this->successResponse($this->eventTypePresenter->presentCollection($response));
    }

    public function store(EventTypeRequest $request, AddEventTypeAction $action): JsonResponse
    {
        $response = $action
            ->execute(new AddEventTypeRequest(
                $request->get('name'),
                $request->get('description'),
                $request->get('slug'),
                $request->get('color'),
                (int)$request->get('duration'),
                $request->get('timezone'),
                (bool)$request->get('disabled'),
                $request->get('availabilities'),
            ))
            ->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($response), JsonResponse::HTTP_CREATED);
    }

    public function getEventTypeById(string $id, GetEventTypeByIdAction $action): JsonResponse
    {
        $eventType = $action
            ->execute(new GetByIdRequest((int)$id))
            ->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }

    public function update(string $id, EventTypeRequest $request, UpdateEventTypeAction $action): JsonResponse
    {
        $eventType = $action
            ->execute(
                new UpdateEventTypeRequest(
                    (int)$id,
                    $request->get('name'),
                    $request->get('description'),
                    $request->get('slug'),
                    $request->get('color'),
                    (int)$request->get('duration'),
                    $request->get('timezone'),
                    (bool)$request->get('disabled'),
                    $request->get('availabilities'),
                )
            )->getEventType();

        return $this->successResponse($this->eventTypePresenter->present($eventType));
    }

    public function destroy(string $id, DeleteEventTypeAction $action): JsonResponse
    {
        $action->execute(new DeleteEventTypeRequest((int)$id));

        return $this->emptyResponse();
    }

    public function changeDisabledById(
        string $id,
        ChangeDisabledEventTypeRequest $request,
        ChangeDisabledByIdAction $action
    ): JsonResponse {
        $action->execute(new ChangeDisabledByIdRequest(
            (int)$id,
            (bool)$request->disabled
        ));
        return $this->emptyResponse();
    }
}
