<?php

namespace App\Notifications;

use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class PasswordResetUserNotification extends ResetPassword
{
    public function toMail($user)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        $url = url(route('password.reset',['token' => $this->token,'email' => $user->email],false));
        $mail = new ResetPasswordMail($user,$url);
        return $mail->to($user->email);
    }
}
