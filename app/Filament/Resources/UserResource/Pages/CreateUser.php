<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use App\Notifications\UserRegisteredEmail;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Ambil plain password untuk dikirim di notifikasi
        $plainPassword = $data['password_plain'] ?? null;

        // Hash password sebelum simpan
        if (isset($data['password'])) {
            $data['password'] = bcrypt($plainPassword ?? $data['password']);
        }

        // Jangan simpan password_plain ke DB
        unset($data['password_plain']);

        // Buat user
        $user = static::getModel()::create($data);

        // Inject plain password langsung ke property model (tidak tersimpan di DB)
        $user->password_plain = $plainPassword;

        // Kirim notifikasi
        try {
            $user->notify(new UserRegisteredEmail($plainPassword ?? '[Tidak Diketahui]'));
            Log::info("Notification sent to {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Notification failed for {$user->email}: {$e->getMessage()}");
        }

        return $user;
    }


    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl();
    }
}
