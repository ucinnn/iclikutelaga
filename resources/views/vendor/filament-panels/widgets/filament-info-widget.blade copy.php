<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="grid grid-cols-5 md:grid-cols-5 gap-1">
            <div class="flex items-center gap-x-0.5 px-1 py-0.5 bg-white dark:bg-gray-800 rounded-lg shadow" style="width:100px;">
                <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                <div class="leading-tight">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Super Admin</div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ \App\Models\User::where('role', 'superadmin')->count() }}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-x-0.5 px-1 py-0.5 bg-white dark:bg-gray-800 rounded-lg shadow" style="width:100px;">
                <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                <div class="leading-tight">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Super Admin</div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ \App\Models\User::where('role', 'superadmin')->count() }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-x-0.5 px-1 py-0.5 bg-white dark:bg-gray-800 rounded-lg shadow" style="width:100px;">
                <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                <div class="leading-tight">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Super Admin</div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ \App\Models\User::where('role', 'superadmin')->count() }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-x-0.5 px-1 py-0.5 bg-white dark:bg-gray-800 rounded-lg shadow" style="width:100px;">
                <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                <div class="leading-tight">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Super Admin</div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ \App\Models\User::where('role', 'superadmin')->count() }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-x-0.5 px-1 py-0.5 bg-white dark:bg-gray-800 rounded-lg shadow" style="width:100px;">
                <x-icon name="heroicon-o-users" class="w-5 h-5 text-primary-500" />
                <div class="leading-tight">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Super Admin</div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ \App\Models\User::where('role', 'superadmin')->count() }}
                    </div>
                </div>
            </div>
        
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
