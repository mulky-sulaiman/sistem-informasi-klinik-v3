<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrugCategoryResource\Pages;
use App\Filament\Resources\DrugCategoryResource\RelationManagers;
use App\Models\DrugCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DrugCategoryResource extends Resource
{
    protected static ?string $model = DrugCategory::class;

    protected static ?string $navigationIcon = 'tabler-pill';

    // protected static ?string $modelLabel = 'employee';
    // protected static ?string $pluralModelLabel = 'employees';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Medication Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDrugCategories::route('/'),
            'create' => Pages\CreateDrugCategory::route('/create'),
            'view' => Pages\ViewDrugCategory::route('/{record}'),
            'edit' => Pages\EditDrugCategory::route('/{record}/edit'),
        ];
    }
}
