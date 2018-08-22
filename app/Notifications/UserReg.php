<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserReg extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        //获取注册认证token
        $token = $this->user->getRegToken($this->user);
        $url = config('app.url') . '/reg/token/' . $token['token'];
        \Log::error('123456');
        return (new MailMessage())
            ->line('Email 地址验证')
            ->line($this->user->name . ',您只需点击下面的链接即可激活您的帐号')
            ->action('点我', $url)
            ->line('fanbbs');
    }


}
