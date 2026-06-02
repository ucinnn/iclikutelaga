<?php

namespace App\Filament\Clusters\Blog\Resources\PostsResource\Pages;

use App\Filament\Clusters\Blog\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosts extends EditRecord
{
    protected static string $resource = PostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
