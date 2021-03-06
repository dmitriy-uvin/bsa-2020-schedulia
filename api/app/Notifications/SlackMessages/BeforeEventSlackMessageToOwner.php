<?php

declare(strict_types=1);

namespace App\Notifications\SlackMessages;

use App\Entity\Event;
use Illuminate\Notifications\Messages\SlackMessage;

class BeforeEventSlackMessageToOwner extends SlackMessage
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $eventType = $event->eventType;
        $owner = $event->eventType->owner;

        $greetings = "Hi, {$owner->name}" . PHP_EOL .
            "An event {$eventType->name} will start in 10 minutes." . PHP_EOL .
            "Prepare for it!";

        $message = $this
            ->success()
            ->to($owner->slack_channel)
            ->content($greetings)
            ->attachment(function ($attachment) use ($event, $eventType) {
                $attachment->fields([
                    'Event Type' => $eventType->name,
                    'Event DateTime' => $event->start_date . ' (UTC)',
                    'Invitee Name' => $event->invitee_name,
                    'Invitee Email' => $event->invitee_email,
                    'Invitee Timezone' => $event->timezone,
                ]);
            });

        if ($this->event->eventType->location_type == 'zoom') {
            $message .= 'Your Zoom meeting link' .
                '<a href="' . $this->event->zoom_meeting_link . '">' . "{$this->event->zoom_meeting_link}" . '</a>';
        }

        if ($this->event->eventType->location_type == 'whale') {
            $message .= 'Your Whale meeting link' .
                '<a href="' . $this->event->whale_meeting_link . '">' . "{$this->event->whale_meeting_link}" . '</a>';
        }
        return $message;
    }
}
