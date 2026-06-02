<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;

class EditUserProfile extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Hanya izinkan user edit dirinya sendiri
        $authUser = Filament::auth()->user();
        if ($authUser->id !== $this->record->id) {
            abort(403);
        }

        return $data;
    }

    public static function getResource(): string
    {
        return UserResource::class;
    }

    protected function authorizeAccess(): void
    {
        // Pastikan hanya pemilik akun yang bisa akses
        if (Filament::auth()->id() !== $this->record->id) {
            abort(403);
        }
    }
}
