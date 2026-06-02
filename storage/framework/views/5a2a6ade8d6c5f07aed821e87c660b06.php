<!DOCTYPE html>
<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(__('filament-panels::layout.direction') ?? 'ltr'); ?>"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'fi min-h-screen',
        'dark' => filament()->hasDarkModeForced(),
    ]); ?>"
>
<head>
    <meta charset="utf-8">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php if($favicon = filament()->getFavicon() ?? asset('images/logo.png')): ?>
        <link rel="icon" type="image/png" href="<?php echo e($favicon); ?>" />
    <?php endif; ?>

    <?php
        $title = trim(strip_tags(($livewire ?? null)?->getTitle() ?? ''));
        $brandName = trim(strip_tags(filament()->getBrandName()));
    ?>

    <title>
        <?php echo e(filled($title) ? "{$title} - " : null); ?> <?php echo e($brandName); ?>

    </title>

    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }

        @media (max-width: 1023px) {
            [x-cloak='-lg'] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak='lg'] {
                display: none !important;
            }
        }

        /* Text color changes based on theme mode */
        :root {
            --font-family: '<?php echo filament()->getFontFamily(); ?>';
            --default-theme-mode: <?php echo e(filament()->getDefaultThemeMode()->value); ?>;
            --light-text-color: #f3f4f6;
            --dark-text-color: #0d141e;
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
        
        /* News text style */
        .dark .news-text {
            color: #2563eb !important; /* Blue color */
        }
        
        /* Ensure post titles are visible */
        .dark .post-title {
            color: var(--light-text-color) !important;
        }
        
        /* Featured posts section */
        .dark .featured-posts h2 {
            color: var(--light-text-color) !important;
        }
        
        /* More Posts button */
        .dark .more-posts {
            color: #eab308 !important;
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

    <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>

    <?php echo e(filament()->getTheme()->getHtml()); ?>

    <?php echo e(filament()->getFontHtml()); ?>


<?php echo $__env->yieldPushContent('styles'); ?>


<?php if(! filament()->hasDarkMode()): ?>
    <script>
        localStorage.setItem('theme', 'light')
    </script>
<?php elseif(filament()->hasDarkModeForced()): ?>
    <script>
        localStorage.setItem('theme', 'dark')
    </script>
<?php else: ?>
    <script>
        const loadDarkMode = () => {
            window.theme = localStorage.getItem('theme') ?? <?php echo \Illuminate\Support\Js::from(filament()->getDefaultThemeMode()->value)->toHtml() ?>

            if (
                window.theme === 'dark' ||
                (window.theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                        .matches)
            ) {
                document.documentElement.classList.add('dark')
                document.body.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
                document.body.classList.remove('dark')
            }
        }

        loadDarkMode()
        
        document.addEventListener('livewire:navigated', loadDarkMode)
        
        // Listen for theme changes and update classes accordingly
        window.addEventListener('storage', (event) => {
            if (event.key === 'theme') {
                loadDarkMode()
            }
        })
    </script>
<?php endif; ?>

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="antialiased">
    <?php echo $__env->yieldContent('hero'); ?>
    <?php echo e($slot); ?>

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    
    <script>
        // This script will run after the page loads to fix any remaining dark text issues
        document.addEventListener('DOMContentLoaded', function() {
            function fixDarkModeText() {
                if (document.documentElement.classList.contains('dark')) {
                    // Target all text elements
                    const allElements = document.querySelectorAll('*');
                    
                    allElements.forEach(el => {
                        if (el.tagName !== 'HTML' && el.tagName !== 'SCRIPT' && el.tagName !== 'STYLE') {
                            const computedStyle = window.getComputedStyle(el);
                            const color = computedStyle.color;
                            
                            // Check if this is a dark color that needs fixing
                            if (color.includes('rgb(0, 0, 0)') || 
                                color.includes('rgb(31, 41, 55)') || 
                                color.includes('rgb(17, 24, 39)') ||
                                color.includes('rgba(0, 0, 0')) {
                                
                                // Skip elements that should keep their color
                                if (!el.classList.contains('text-yellow-500') &&
                                    !el.classList.contains('text-primary') &&
                                    !el.className.includes('text-yellow-') &&
                                    el.tagName !== 'BUTTON' && 
                                    !el.closest('button')) {
                                    
                                    el.style.setProperty('color', '#f3f4f6', 'important');
                                }
                            }
                        }
                    });
                    
                    // Special handling for post titles
                    const postTitles = document.querySelectorAll('.featured-post-title, .post-title');
                    postTitles.forEach(el => {
                        el.style.setProperty('color', '#f3f4f6', 'important');
                    });
                }
            }
            
            // Run immediately and then on any theme change
            fixDarkModeText();
            
            // Watch for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        fixDarkModeText();
                    }
                });
            });
            
            observer.observe(document.documentElement, {attributes: true});
            
            // Also run on storage events
            window.addEventListener('storage', function(event) {
                if (event.key === 'theme') {
                    setTimeout(fixDarkModeText, 100);
                }
            });
        });
    </script>
</body>

</html><?php /**PATH C:\laragon\www\information-center\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>