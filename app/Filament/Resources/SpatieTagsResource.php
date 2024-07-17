<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Spatie\Tags\Tag;
use Filament\Forms\Form;
use App\Models\SpatieTags;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\SpatieTagsColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SpatieTagsResource\Pages;
use App\Filament\Resources\SpatieTagsResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class SpatieTagsResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSpatieTags::route('/'),
            'create' => Pages\CreateSpatieTags::route('/create'),
            //'edit' => Pages\EditSpatieTags::route('/{record}/edit'),
        ];
    }
}
