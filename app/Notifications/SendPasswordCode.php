<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class SendPasswordCode extends Notification
{
    private $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return 'درمانگاه شبانه روزی امام حسین (ع)
        رمز عبور: ' . $this->password;
    }
}
