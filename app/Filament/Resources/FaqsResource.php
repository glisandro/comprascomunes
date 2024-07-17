<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Faqs;
use Filament\Tables;
use Spatie\Tags\Tag;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Tables\Columns\TagsColumn;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
//use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\MorphToSelect;
use Filament\Tables\Columns\SpatieTagsColumn;
use App\Filament\Resources\FaqsResource\Pages;
use App\Filament\Forms\Components\SpatieTagsInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FaqsResource\RelationManagers;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;


class FaqsResource extends Resource
{
    protected static ?string $model = Faqs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'FAQs';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('pregunta')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('respuesta')
                    ->required()
                    ->columnSpanFull(),
                //SpatieTagsInput::make('tags'),
                Select::make('tags')
                    ->relationship(name: 'tags', titleAttribute: 'name')
                    ->multiple()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                    Tables\Columns\TextColumn::make('pregunta')
                        
                        ->weight(FontWeight::Bold)
                        ->limit(30)
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('respuesta')
                        
                        ->limit(75)
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('tags.name')
                        //->color('primary')
                        //->html()
                        ->badge()
                        ->searchable(),

                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                
            ])
            ->filters([
                SelectFilter::make('tags')
                    ->multiple()
                    ->preload()
                    ->relationship('tags', 'name') 
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver'),
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaqs::route('/create'),
            'edit' => Pages\EditFaqs::route('/{record}/edit'),
            'view' => Pages\ViewFaqs::route('/{record}/view'),
        ];
    }
}
