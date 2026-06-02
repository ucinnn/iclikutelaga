<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex flex-wrap gap-2 min-h-[100px]">
            @foreach ([
                ['label' => 'Super Admin', 'role' => 'superadmin'],
                ['label' => 'Admin', 'role' => 'admin'],
                ['label' => 'Author', 'role' => 'author'],
                ['label' => 'User', 'role' => 'user'],
                ['label' => 'Total', 'role' => null],
            ] as $stat)
                <div class="flex items-center gap-x-1 px-2 py-1 bg-white dark:bg-gray-800 rounded-md shadow flex-1 min-w-[120px]">
                    <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                    <div class="leading-tight">
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</div>
                        <div class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $stat['role'] ? \App\Models\User::where('role', $stat['role'])->count() : \App\Models\User::count() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
