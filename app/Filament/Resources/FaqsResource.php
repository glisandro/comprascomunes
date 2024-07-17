<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Faqs;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Tables\Columns\TagsColumn;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\SpatieTagsColumn;
use App\Filament\Resources\FaqsResource\Pages;
use Filament\Forms\Components\SpatieTagsInput;
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
                RichEditor::make('pregunta')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('respuesta')
                    ->required()
                    ->columnSpanFull(),
                SpatieTagsInput::make('tags')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('pregunta')
                        
                        ->weight(FontWeight::Bold)
                        ->limit(100)
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('respuesta')
                        
                        ->limit(300)
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('tags.name')
                        //->color('primary')
                        //->html()
                        ->badge()
                        ->searchable()
                ])
            ])
            ->filters([
                SelectFilter::make('tags')
                    ->multiple()
                    ->preload()
                    ->relationship('tags', 'name') 
                /*SelectFilter::make('tags')
                    ->options(function () {
                        return faqs::all()
                            ->pluck('tags')
                            ->flatten()
                            ->unique()
                            ->filter()
                            ->mapWithKeys(fn($tag) => [$tag => $tag])
                            ->toArray();
                    })
                    ->multiple()
    
                ->query(function ($query, array $data) {

                    if(count($data['values']) > 0) {
                        foreach ($data as $index => $value) {
                            if ($index === 0) {
                                $query->whereRaw('JSON_CONTAINS(tags, ?)', [json_encode($value)]);
                            } else {
                                $query->orWhereRaw('JSON_CONTAINS(tags, ?)', [json_encode($value)]);
                            }
                        }
                    }
                })*/
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaqs::route('/create'),
            'edit' => Pages\EditFaqs::route('/{record}/edit'),
        ];
    }
}
