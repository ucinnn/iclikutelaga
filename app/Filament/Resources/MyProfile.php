<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.admin.MyProfile';

    protected static ?string $title = 'My Profile';
    protected static ?string $navigationGroup = 'Account';
    protected static ?int $navigationSort = 999;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $this->form->fill([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
        ];
    }

    public function submit(): void
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $user->update($this->form->getState());
            $this->notify('success', 'Profile updated.');
        } else {
            $this->notify('danger', 'Failed to update profile.');
        }
    }

    protected function getFormModel(): \Illuminate\Database\Eloquent\Model
    {
        return User::find(Auth::id()); // ensures it's a proper Eloquent model
    }

    public static function getSlug(): string
    {
        return 'my-profile';
    }
}
