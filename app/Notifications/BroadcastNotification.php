<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use DB;
use App\MasterNotifikasi;
use Benwilkins\FCM\FcmMessage;

class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $user;
    public $judul;
    public $pesan;

    public function __construct(User $user, $judul, $pesan)
    {
        $this->user = $user;
        $this->judul = $judul;
        $this->pesan = $pesan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable) 
    {
        $agents = DB::table('users')->where('device_token', '!=', null)->pluck('device_token')->toArray();
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $agents;
        $notification = [
            'body' => $this->pesan,
            'title' => $this->judul,
            'priority' => 'high',
            'image' => 'https://dl.dropboxusercontent.com/u/887989/antshot.png',
            'sound' => true,
        ];
        
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'registration_ids' => $token, //multple token array
            // 'to'        => '/topics/global', //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
        $headers = [
            'Authorization: key=AIzaSyBd3fkYDybtqT7RmEkz8-nm6FbnSkW1tkA',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return [
            'id' => $this->user->id,
            'data' => $this->pesan,
            'notification' => 'fcm'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
