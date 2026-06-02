<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredEmail extends Notification
{
    use Queueable;

    protected string $plainPassword;

    public function __construct(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun Anda Telah Terdaftar')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Akun Anda telah berhasil didaftarkan.')
            ->line('Berikut detail akun Anda:')
            ->line('NIK: ' . $notifiable->NIK)
            ->line('Nama: ' . $notifiable->name)
            ->line('E-Mail: ' . $notifiable->email)
            ->line('Password: ' . $notifiable->password)
            ->line('Demi keamanan password anda kami enkripsi silahkan reset password untuk membuat password baru sebelum login ')
            ->action('Reset Password', url('/admin/password-reset/request'))
            ->line('Jika Anda tidak mendaftarkan akun ini, abaikan email ini.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Akun berhasil didaftarkan',
            'message' => 'Selamat datang, akun Anda telah aktif.',
            'url' => url('/login'),
        ];
    }
}
