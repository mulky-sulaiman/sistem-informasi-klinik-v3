<?php

namespace App\Filament\Resources\AppointmentResource\RelationManagers;

use App\Models\Appointment;
use App\Models\Drug;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;


class PrescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptions';

    // protected $listeners = ['refreshAppointment' => '$refresh'];


    public function form(Form $form): Form
    {
        $appointment = $this->getOwnerRecord();
        //clock()->info($appointment->clinic_user()->first()->clinic_id);
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
                        // Forms\Components\Toggle::make('is_prepared')->label(__('Is Prepared'))
                        //     ->required(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('drug.sku')->label(__('SKU')),
                Tables\Columns\TextColumn::make('drug.name')->label(__('Drug')),
                Tables\Columns\TextColumn::make('drug.drug_category.name')->label(__('Drug Category')),
                Tables\Columns\TextColumn::make('description')->label(__('Description')),
                Tables\Columns\TextColumn::make('quantity')->label(__('Quantity')),
                Tables\Columns\TextColumn::make('price')->label(__('Price'))->money('IDR'),
                Tables\Columns\TextColumn::make('discount')->label(__('Discount')),
                Tables\Columns\TextColumn::make('amount')->label(__('Amount'))->money('IDR'),
                //Tables\Columns\IconColumn::make('is_prepared')->label(__('Is Prepared'))->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // ->after(function ($livewire) {
                //     $livewire->dispatch('refreshAppointment');
                // }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
