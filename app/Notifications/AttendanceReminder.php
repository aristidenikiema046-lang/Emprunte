<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AttendanceReminder extends Notification
{
    private $message;
    private $link;

    public function __construct($message, $link)
    {
        $this->message = $message;
        $this->link = $link;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => $this->message,
            'link' => $this->link,
        ];
    }
}