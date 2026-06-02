<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Filament\Notifications\Livewire\HasDatabaseNotifications;

class LiveNotification extends Component
{
    use HasDatabaseNotifications;

    public function render()
    {
        return view('livewire.live-notification', [
            'notifications' => $this->getNotifications(),
            'unreadNotificationsCount' => $this->getUnreadNotificationsCount(),
            'pollingInterval' => $this->getPollingInterval(),
            'trigger' => $this->getTrigger(),
            'broadcastChannel' => $this->getBroadcastChannel(),
        ]);
    }
}