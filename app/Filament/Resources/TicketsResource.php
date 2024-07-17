<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Faqs;
use Filament\Tables;
use App\Models\Tickets;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Resources\TicketsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TicketsResource\RelationManagers;

class TicketsResource extends Resource
{
    protected static ?string $model = Faqs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'FAQs (Últimas modificadas)';

    protected static ?int $navigationSort = 2;

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
            ->modifyQueryUsing(function (Builder $query) { 
                $query->limit(1); 
            }) 
            ->columns([
                Tables\Columns\TextColumn::make('pregunta')
                ->lineClamp(2)
                    ->weight(FontWeight::Bold)
                    ->limit(50)
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('respuesta')
                    ->color('primary')
                    ->limit(70)
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tags.name')
                    //->color('primary')
                    //->html()
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                    //->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                    //->toggleable(isToggledHiddenByDefault: true),
            ])
            
            ->filters([     
                /*SelectFilter::make('tags')
                    ->options(function () {
                        return Faqs::all()
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

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();

        return $query
            ->whereColumn('updated_at', '<>' , 'created_at')
            ->orderByDesc('updated_at', 0)
            ->limit(1);
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTickets::route('/create'),
            'edit' => Pages\EditTickets::route('/{record}/edit'),
        ];
    }
}
