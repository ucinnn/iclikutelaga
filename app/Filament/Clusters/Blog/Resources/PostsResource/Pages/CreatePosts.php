<?php

namespace App\Filament\Clusters\Blog\Resources\PostsResource\Pages;

use App\Filament\Clusters\Blog\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePosts extends CreateRecord
{
    protected static string $resource = PostsResource::class;
}
