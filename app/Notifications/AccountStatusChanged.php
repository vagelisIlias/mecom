<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountStatusChanged extends Notification
{
    use Queueable;

    protected $status;

    protected $message;

    protected $url;

    protected $actionText;

    protected $lineText;

    /**
     * Create a new notification instance.
     *
     * @param  string  $status The new account status ('active' or 'inactive')
     * @param  string  $message The custom message for the notification
     * @param  string  $url The dynamic URL for the notification
     */
    public function __construct($status, $message, $url, $actionText, $lineText)
    {
        $this->status = $status;
        $this->message = $message;
        $this->url = $url;
        $this->actionText = $actionText;
        $this->lineText = $lineText;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->message)
            ->action($this->actionText, $this->url)
            ->line($this->lineText);
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
