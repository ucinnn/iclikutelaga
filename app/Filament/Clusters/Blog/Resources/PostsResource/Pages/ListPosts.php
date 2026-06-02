<?php

namespace App\Filament\Clusters\Blog\Resources\PostsResource\Pages;

use App\Filament\Clusters\Blog\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}