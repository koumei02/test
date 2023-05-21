<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'パスワード変更のご案内';  

    public function __construct($user,$url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function build()
    {
        $result =  $this->view('emails.reset_password',[
            'user'=>$this->user,
            'url'=>$this->url
        ]);
        return $result;
    }
}