<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientFeedbackSubmitted extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     * @param  mixed  $proposal
     * @param  string $clientMessage
     * @return void
     */

     private $proposal;
     private $clientMessage;
    public function __construct($proposal, $clientMessage)
    {
        $this->proposal = $proposal;
        $this->clientMessage = $clientMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Feedback has been submitted for the proposal: ' . $this->proposal->proposal_title)
                    ->line('Proposal Status: ' . $this->proposal->status)
                    ->line('Client message: ' . $this->clientMessage)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'proposal_title' => $this->proposal->proposal_title,
            'status' => $this->proposal->status,
            'client_message' => $this->clientMessage,
        ];
    }
}
