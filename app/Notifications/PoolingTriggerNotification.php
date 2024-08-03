<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Messages\SlackMessage;


class PoolingTriggerNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->data['subject'])
            ->markdown('mail.pooling-trigger', ['data' => $this->data]);
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        
    return (new SlackMessage)
        ->content($this->data['subject'])
        ->attachment(function ($attachment) {
            $attachment->title($this->data['job_title'])
            ->content($this->data['job_link']);
        });

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
