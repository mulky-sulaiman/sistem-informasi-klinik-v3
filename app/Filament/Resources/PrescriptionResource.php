<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\PrescriptionResource\Pages;
use App\Filament\Resources\PrescriptionResource\RelationManagers;
use App\Models\Drug;
use App\Models\Prescription;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?string $navigationIcon = 'tabler-prescription';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        $record = $form->getRecord();
        $appointment = $record->appointment()->first();

        //dd($appointment);

        return $form
            ->schema([
                Section::make(__('Prescription Data'))
                    // ->label('Clinic\'s Basic Info')
                    ->description(__('Required Drug\'s data for the Prescription'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Placeholder::make('clinic')
                            ->label('Clinic')
                            ->content($appointment->clinic_user()->first()->clinic()->first()->name),
                        Forms\Components\Select::make('drug_id')
                            ->relationship(
                                name: 'drug',
                                titleAttribute: 'name',
                                // ignoreRecord: true,
                                modifyQueryUsing: fn (Builder $query) => $query->where('in_stock', true)->where('clinic_id', $appointment->clinic_user()->first()->clinic_id)
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} : {$record->sku}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->live()
                            ->helperText(__('Filtered by Related Clinic & Drug\'s Ready Stock only')),
                        Placeholder::make('drug_category')
                            ->content(function ($get) {
                                $drug = Drug::find($get('drug_id'));
                                $category = ($drug) ? $drug->drug_category()->first()->name : '-';
                                return $category;
                            })
                            ->live(),
                        Placeholder::make('drug_stock')
                            ->content(function ($get) {
                                $drug = Drug::find($get('drug_id'));
                                $stock = ($drug) ? $drug->stock : '-';
                                return $stock;
                            })
                            ->live(),
                        Forms\Components\TextArea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_prepared')->label(__('Is Prepared'))
                            ->required(),
                    ]),

                Section::make(__('Price Calculation'))
                    // ->label(__('Automatic calculation for the Treatment\'s Price'))
                    ->description(__('Automatic calculation for the Prescription\'s Price'))
                    ->columnSpan(1)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label(__('Quantity'))
                            ->required()
                            ->live()
                            ->numeric()
                            ->maxValue(function ($get) {
                                $drug = Drug::find($get('drug_id'));
                                $stock = ($drug) ? $drug->stock : 0;
                                return $stock;
                            }),
                        Placeholder::make('drug_price')
                            ->label(__('Drug Price'))
                            ->content(function ($get) {
                                $drug = Drug::find($get('drug_id'));
                                $price = ($drug) ? $drug->price : 0;
                                return Number::currency($price, 'IDR');
                            })
                            ->live(),
                        Forms\Components\TextInput::make('discount')
                            ->required()
                            ->live()
                            ->suffix('%')
                            ->numeric(),
                        Placeholder::make('amount')
                            ->label(__('Amount'))
                            ->content(function ($get) {
                                $drug = Drug::find($get('drug_id'));
                                $price = ($drug) ? $drug->price : 0;
                                $q = $get('quantity');
                                $p = $price;
                                $d = $get('discount');
                                $a = $q * ($p - ($p * ($d / 100)));
                                return Number::currency($a, 'IDR');
                            })
                            ->live(),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if (!$user->hasRole(RoleEnum::SUPER_ADMIN->value) && !$user->hasRole(RoleEnum::ADMIN->value)) {
                    $query->select('prescriptions.*');
                    $query->leftJoin('appointments', 'appointment_id', '=', 'appointments.id');
                    $query->leftJoin('clinic_user', 'clinic_user.id', '=', 'appointments.clinic_user_id');
                    $query->where('clinic_user.clinic_id', $user->clinics()->first()->id);
                    $query->where('appointments.status', AppointmentStatusEnum::DIAGNOSED->value);
                    clock()->info($query->toRawSql());
                } else {
                    $query->select('prescriptions.*');
                    $query->leftJoin('appointments', 'appointment_id', '=', 'appointments.id');
                    $query->where('appointments.status', AppointmentStatusEnum::DIAGNOSED->value);
                    clock()->info($query->toRawSql());
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('drug.sku')->label(__('SKU')),
                Tables\Columns\TextColumn::make('drug.name')->label(__('Drug')),
                Tables\Columns\TextColumn::make('drug.drug_category.name')->label(__('Drug Category')),
                Tables\Columns\TextColumn::make('description')->label(__('Description'))->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('quantity')->label(__('Quantity')),
                Tables\Columns\TextColumn::make('price')->label(__('Price'))->money('IDR'),
                Tables\Columns\TextColumn::make('discount')->label(__('Discount')),
                Tables\Columns\TextColumn::make('amount')->label(__('Amount'))->money('IDR'),
                Tables\Columns\IconColumn::make('is_prepared')->label(__('Is Prepared'))->boolean(),
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
                    BulkAction::make('prepare')
                        ->label(__('Mark as Prepared'))
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->setPrepare()),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup('appointment.id');
        // ->groups([
        //     Group::make('appointment.id')
        //         ->label('Appointment'),
        // ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePrescriptions::route('/'),
        ];
    }
}
