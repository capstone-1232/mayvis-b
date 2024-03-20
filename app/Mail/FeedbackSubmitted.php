<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $proposalTitle;
    public $proposalStatus;
    public $clientMessage;
    public $userName;
    

    public function __construct(string $proposalTitle, string $proposalStatus, string $clientMessage = "", string $userName)
    {
        $this->proposalTitle = $proposalTitle;
        $this->proposalStatus = $proposalStatus;
        $this->clientMessage = $clientMessage;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Feedback Submitted')
                    ->view('emails.feedback')
                    ->with([
                        'proposalTitle' => $this->proposalTitle,
                        'proposalStatus' => $this->proposalStatus,
                        'clientMessage' => $this->clientMessage,
                        'userName' => $this->userName,
                    ]);
    }
}

