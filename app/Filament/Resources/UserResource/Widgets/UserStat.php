<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UserStat extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = null; // Opsional, hapus jika tidak perlu auto-refresh

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All user registered (All Roles)')
                ->icon('heroicon-o-users')
                ->color('warning'),

            Stat::make('Admins', User::where('role', 'admin')->count())
                ->description('User with admin roles')
                ->icon('heroicon-o-shield-check')
                ->color('warning'),

            Stat::make('Authors', User::where('role', 'author')->count())
                ->description('User with author roles')
                ->icon('heroicon-o-pencil-square')
                ->color('warning'),

            Stat::make('Users', value: User::where('role', 'user')->count())
                ->description('User with user roles')
                ->icon('heroicon-o-users')
                ->color('warning'),

        ];
    }
}
