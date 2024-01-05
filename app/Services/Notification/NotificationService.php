<?php

namespace App\Services\Notification;

class NotificationService
{
    public function message($message, $type = ''): array
    {
        return [
            'message' => $message,
            'alert-type' => $type,
        ];
    }
}
