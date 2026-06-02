<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
      dir="<?php echo e(__('filament-panels::layout.direction') ?? 'ltr'); ?>"
      class="fi min-h-screen <?php if(filament()->hasDarkModeForced()): ?> dark <?php endif; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Filament')); ?></title>

    <!-- Hide elements for Alpine transitions -->
    <style>
        [x-cloak] { display: none !important; }
        @media (max-width: 1023px) { [x-cloak='-lg'] { display: none !important; } }
        @media (min-width: 1024px) { [x-cloak='lg'] { display: none !important; } }
    </style>

    <!-- Theme color variables -->
    <style>
            /* Text color changes based on theme mode */
            :root {
            --font-family: '<?php echo filament()->getFontFamily(); ?>';
            --default-theme-mode: <?php echo e(filament()->getDefaultThemeMode()->value); ?>;
            --light-text-color: #f3f4f6;
            --dark-text-color: #1f2937;
        }
        /* Base text colors */
        body {
            color: var(--dark-text-color);
        }

        /* Force all text elements to have proper contrast in dark mode */
        .dark {
            color: var(--light-text-color) !important;
            background-color: #111827;
        }

        /* Target all text elements */
        .dark *, .dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6,
        .dark p, .dark div, .dark span, .dark a:not(.text-primary):not([class*="text-"]),
        .dark li, .dark label, .dark small {
            color: var(--light-text-color) !important;
        }

        /* Special handling for specific elements */
        .dark a:hover {
            color: #93c5fd !important; /* Light blue on hover */
        }

        /* Preserve yellow for YELO text */
        .dark .text-yellow-500,
        .dark [class*="text-yellow-"],
        .dark .text-primary {
            color: #eab308 !important; /* Yellow color */
        }
                /* Override any dark text that might be applied by other styles */
                .dark [style*="color: #000"],
        .dark [style*="color: black"],
        .dark [style*="color: rgb(0, 0, 0)"],
        .dark [style*="color: rgba(0, 0, 0"],
        .dark [style*="color:#000"],
        .dark [style*="color:black"],
        .dark [style*="color:rgb(0,0,0)"],
        .dark [style*="color:rgba(0,0,0"] {
            color: var(--light-text-color) !important;
        }
    </style>

    <?php if(! filament()->hasDarkMode()): ?>
    <script>
        localStorage.setItem('theme', 'light')
    </script>
    <?php elseif(filament()->hasDarkModeForced()): ?>
    <script>
        localStorage.setItem('theme', 'dark')
    </script>
    <?php else: ?>

    <!-- Filament styles and fonts -->
    <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>
    <?php echo e(filament()->getTheme()->getHtml()); ?>

    <?php echo e(filament()->getFontHtml()); ?>

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="antialiased">

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-md fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <?php
                $brandName = filament()->getBrandName();
                $brandLogo = filament()->getBrandLogo();
                $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
                $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
                $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

                $logoStyles = "height: {$brandLogoHeight}";
            ?>

            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2 group">
                
                <?php if(filled($brandLogo)): ?>
                    <img
                        src="<?php echo e($brandLogo); ?>"
                        alt="<?php echo e(__('filament-panels::layout.logo.alt', ['name' => $brandName])); ?>"
                        style="<?php echo e($logoStyles); ?>"
                        class="<?php echo e($hasDarkModeBrandLogo ? 'hidden dark:block' : ''); ?>"
                    />
                <?php endif; ?>

                
                <?php if($hasDarkModeBrandLogo): ?>
                    <img
                        src="<?php echo e($darkModeBrandLogo); ?>"
                        alt="<?php echo e(__('filament-panels::layout.logo.alt', ['name' => $brandName])); ?>"
                        style="<?php echo e($logoStyles); ?>"
                        class="block dark:hidden"
                    />
                <?php endif; ?>

                
                <span class="text-2xl font-bold text-gray-950 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                    <?php echo e($brandName); ?>

                </span>
            </a>


            <div class="hidden md:flex space-x-6 items-center">
                <a href="#" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Dashboard</a>
                <a href="#" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Profile</a>
                <?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-gray-700 dark:text-gray-200 hover:text-red-500 transition">
                        Logout
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(url('/admin/login')); ?>" class="text-gray-700 dark:text-red-400 hover:text-red-600">
                    Login
                </a>
            <?php endif; ?>            
                <form id="logout-form" action="#" method="POST" class="hidden"><?php echo csrf_field(); ?></form>

                <!-- Tombol toggle mode -->
                <button id="toggle-theme"
                    class="ml-4 px-3 py-1 rounded-md bg-gray-500 dark:bg-gray-800 text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-700 transition"
                    title="Toggle dark mode">
                    🌓 Mode
                </button>
            </div>

            </div>
        </div>
    </nav>
    <script>
        const toggleButton = document.getElementById('toggle-theme');

        toggleButton?.addEventListener('click', () => {
            const current = localStorage.getItem('theme');
            const next = current === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme();
        });
    </script>


    <div class="h-16"></div>

    <!-- Main Content -->
    <?php echo $__env->yieldContent('content'); ?>
        <script>
            const applyTheme = () => {
                const theme = localStorage.getItem('theme') ?? <?php echo \Illuminate\Support\Js::from(filament()->getDefaultThemeMode()->value)->toHtml() ?>;
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = theme === 'dark' || (theme === 'system' && prefersDark);

                document.documentElement.classList.toggle('dark', isDark);
            };

            applyTheme();

            window.addEventListener('storage', (e) => {
                if (e.key === 'theme') applyTheme();
            });

            document.addEventListener('livewire:navigated', applyTheme);
        </script>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\information-center\resources\views/components/layouts/navbar.blade.php ENDPATH**/ ?>