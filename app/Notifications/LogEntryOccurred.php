<?php

namespace App\Notifications;

use App\Models\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogEntryOccurred extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Issue $issue)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [GoogleChatChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toGoogleChat($notifiable)
    {
        $source = $this->issue->location->source;
        $location = $this->issue->location;

        $message = "🟡 Log entry occurred {$source->name} ➔ {$location->name}:\n{$this->issue->title}\n";
        $message .= url('/issues/'.$this->issue->id);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
