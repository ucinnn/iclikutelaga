<?php

namespace App\Filament\Clusters\Blog\Resources;

use App\Filament\Clusters\Blog;
use App\Models\Blog\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{

    protected static ?string $navigationGroup = 'Blogs Management';


    protected static ?string $model = Post::class;

    protected static ?string $cluster = Blog::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?int $navigationSort = 1;

    public static function getNavigationSort(): int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Clusters\Blog\Resources\BlogResource\Pages\ListBlogs::route('/'),
            'create' => \App\Filament\Clusters\Blog\Resources\BlogResource\Pages\CreateBlog::route('/create'),
            'edit' => \App\Filament\Clusters\Blog\Resources\BlogResource\Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
