<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class GoogleChatChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toGoogleChat($notifiable);

        Http::post(config('gchat.webhook_url'), [
            'text' => $message,
        ]);
    }
}
