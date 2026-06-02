<?php
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $logoStyles = "height: {$brandLogoHeight}";
?>

<div class="flex items-center gap-2">
    
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

    
    <span class="text-2xl font-bold text-gray-950 dark:text-white">
        <?php echo e($brandName); ?>

    </span>
</div>
<?php /**PATH C:\laragon\www\information-center\resources\views/vendor/filament-panels/components/logo.blade.php ENDPATH**/ ?>