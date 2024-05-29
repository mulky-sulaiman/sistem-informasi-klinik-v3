<?php

namespace App\Filament\Resources\ClinicResource\RelationManagers;

use App\Enums\RoleEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'user';
    protected static ?string $title = 'Members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('name')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (object $state): string => Str::upper($state->value))
                    ->color(fn (object $state): string => match ($state) {
                        RoleEnum::OPERATOR => 'info',
                        RoleEnum::PHARMACIST => 'warning',
                        RoleEnum::DOCTOR => 'success',
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->options([
                        RoleEnum::OPERATOR->value => RoleEnum::OPERATOR->label(),
                        RoleEnum::PHARMACIST->value => RoleEnum::PHARMACIST->label(),
                        RoleEnum::DOCTOR->value => RoleEnum::DOCTOR->label(),
                    ]),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
                // ->after(function ($livewire): void {
                //     dd($livewire);
                // }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
