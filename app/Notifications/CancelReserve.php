<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class CancelReserve extends Notification
{
    private $user_full_name;
    private $doctor_full_name;

    public function __construct($user_full_name, $doctor_full_name)
    {
        $this->user_full_name = $user_full_name;
        $this->doctor_full_name = $doctor_full_name;
    }

    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return $this->user_full_name . ' ' . 'عزیز' .
            ' درخواست کنسل کردن نوبت شما برای دکتر' .
            '<br>' .
            $this->doctor_full_name .
            '<br>' .
            'با موفقیت ثبت شد';
    }
}
