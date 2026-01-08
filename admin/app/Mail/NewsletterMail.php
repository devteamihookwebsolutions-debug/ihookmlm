<?php

namespace Admin\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $body;

    public function __construct($subjectText, $body)
    {

        $this->subjectText = $subjectText;
        $this->body = $body;
    }

    public function build()
    {
     
        // dd('funcrion reached or not');
        return $this->subject($this->subjectText)
    
                    ->html($this->body);
    }
}
