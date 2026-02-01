<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(ServiceRequest $request)
    {
        $this->request = $request;
    }

    public function build()
    {
        return $this
            ->subject('Mentory | Request Status Updated')
            ->view('emails.request-status-changed');
    }
}
