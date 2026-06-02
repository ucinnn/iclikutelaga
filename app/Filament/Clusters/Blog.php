<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Blog extends Cluster
{
    // Pastikan cluster memiliki navigasi yang diaktifkan
    // protected static bool $isNavigationRegistered = true;

    // // Icon untuk cluster di sidebar
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // // Label untuk cluster di sidebar
    // protected static ?string $navigationLabel = 'Blog Management';

    // // Urutan tampilan di sidebar
    // protected static ?int $navigationSort = 10;

    // // Warna badge untuk cluster (opsional)
    // protected static ?string $navigationBadgeColor = 'success';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Blog Management';

    protected static ?int $navigationSort = 0;

    protected static ?string $slug = 'blog';
}
