<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use MohsenBostan\GhasedakSms;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $user_mobile = $notifiable->mobile;
        return GhasedakSms::sendSingleSMS($message, $user_mobile);
    }
}
