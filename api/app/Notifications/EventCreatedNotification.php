<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\User;
use App\Mail\EventCreatedMailToOwner;
use App\Notifications\SlackMessages\EventCreatedSlackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Event $event;
    private EventType $eventType;
    private User $user;

    /**
     * Create a new notifications instance.
     *
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->user = $event->eventType->owner;
    }

    /**
     * Get the notifications's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail'];
        if ($this->user->slack_active) {
            $channels[] = 'slack';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notifications.
     *
     */
    public function toMail($notifiable)
    {
        return new EventCreatedMailToOwner($this->event);
    }

    public function toSlack($notifiable)
    {
        return (new EventCreatedSlackMessage($this->event));
    }

    /**
     * Get the array representation of the notifications.
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
