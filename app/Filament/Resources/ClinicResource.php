<?php

namespace App\Filament\Resources;

use App\Enums\ClinicTypeEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\ClinicResource\Pages;
use App\Filament\Resources\ClinicResource\RelationManagers;
use App\Filament\Resources\ClinicResource\RelationManagers\UsersRelationManager;
use App\Models\Clinic;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class ClinicResource extends Resource
{
    protected static ?string $model = Clinic::class;

    protected static ?string $navigationIcon = 'tabler-building-hospital';

    // protected static ?string $modelLabel = 'employee';
    // protected static ?string $pluralModelLabel = 'employees';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Clinic Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Info')
                    ->label('Clinic\'s Basic Info')
                    ->description('Contains default data to be used as authentication to the system')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->options([
                                ClinicTypeEnum::PRATAMA->value => ClinicTypeEnum::PRATAMA->label(),
                                ClinicTypeEnum::UTAMA->value => ClinicTypeEnum::UTAMA->label(),
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ]),
                Section::make('Region Info')
                    ->label('Patient\'s Domicile')
                    ->description('Contains region related info for Clinic\'s Location')
                    ->columnSpan(1)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('province_id')
                            ->label(__('Province'))
                            ->relationship('province', 'name')
                            ->searchable()
                            ->live()
                            ->preload()
                            ->afterStateUpdated(function (Set $set) {
                                $set('regency_id', null);
                                $set('district_id', null);
                                $set('village_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('regency_id')
                            ->label(__('Regency'))
                            ->options(fn (Get $get): Collection => Regency::query()
                                ->where('province_id', $get('province_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('district_id', null);
                                $set('village_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('district_id')
                            ->label(__('District'))
                            ->options(fn (Get $get): Collection => District::query()
                                ->where('regency_id', $get('regency_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('village_id', null);
                            })
                            ->required(),
                        Forms\Components\Select::make('village_id')
                            ->label(__('Village'))
                            ->options(fn (Get $get): Collection => Village::query()
                                ->where('district_id', $get('district_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                    ]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if (!$user->hasRole(RoleEnum::SUPER_ADMIN->value) && !$user->hasRole(RoleEnum::ADMIN->value)) {
                    // $query->leftJoin('clinic_user', 'clinic_user.id', '=', 'clinic_user_id');
                    $query->where('id', $user->clinics()->first()->id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::upper($state->value))
                    ->color(fn (object $state): string => match ($state) {
                        ClinicTypeEnum::PRATAMA => 'info',
                        ClinicTypeEnum::UTAMA => 'primary',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->limit(80)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->badge()
                    ->label(__('Members Count'))
                    ->counts('user')
                    ->colors(['warning']),
                // Tables\Columns\TextColumn::make('province.name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('regency.name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('district.name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('village.name')
                //     ->searchable(),
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
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClinics::route('/'),
            'create' => Pages\CreateClinic::route('/create'),
            'view' => Pages\ViewClinic::route('/{record}'),
            'edit' => Pages\EditClinic::route('/{record}/edit'),
        ];
    }
}
