<?php

namespace App\Filament\Resources;

use App\Enums\PaymentStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\TransactionResource\RelationManagers\BillsRelationManager;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Number;
use Illuminate\Support\Str;


class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'tabler-businessplan';

    // protected static ?string $modelLabel = 'employee';
    // protected static ?string $pluralModelLabel = 'employees';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make(__('Transaction Data'))
                    // ->label('Clinic\'s Basic Info')
                    ->description(__('Required Drug\'s data for the Prescription'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Placeholder::make('appointment_id')
                            ->label(__('Appointment ID'))
                            ->content(function ($get) {
                                return $get('appointment_id');
                            }),
                        Placeholder::make('patient_name')
                            ->label(__('Patient Name'))
                            ->content(function ($get) {
                                return $get('patient_name');
                            }),

                        Placeholder::make('patient_phone')
                            ->label(__('Patient Phone'))
                            ->content(function ($get) {
                                return $get('patient_phone');
                            }),
                        Placeholder::make('patient_age')
                            ->label(__('Patient Age'))
                            ->content(function ($get) {
                                return $get('patient_age');
                            }),
                        Placeholder::make('doctor_name')
                            ->label(__('Doctor Name'))
                            ->content(function ($get) {
                                return $get('doctor_name');
                            }),
                        Placeholder::make('doctor_phone')
                            ->label(__('Doctor Phone'))
                            ->content(function ($get) {
                                return $get('doctor_phone');
                            }),
                        Placeholder::make('appointment_date')
                            ->label(__('Appointment Date'))
                            ->content(function ($get) {
                                return Carbon::parse($get('appointment_date'))->format('d-m-Y h:i:s');
                            }),
                        Forms\Components\Textarea::make('note')
                            ->columnSpanFull(),
                    ]),
                Section::make(__('Payment Data'))
                    // ->label(__('Automatic calculation for the Treatment\'s Price'))
                    ->description(__('Automatic calculation for the Prescription\'s Price'))
                    ->columnSpan(1)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        Placeholder::make('amount_treatments')
                            ->label(__('Total Treatment'))
                            ->content(function ($get) {
                                return Number::currency($get('amount_treatments'), 'IDR');
                            }),
                        Placeholder::make('amount_prescriptions')
                            ->label(__('Total Prescription'))
                            ->content(function ($get) {
                                return Number::currency($get('amount_prescriptions'), 'IDR');
                            }),
                        Placeholder::make('amount_total')
                            ->label(Str::upper(__('Total Bill')))
                            ->content(function ($get) {
                                return Number::currency($get('amount_total'), 'IDR');
                            }),

                        Placeholder::make('paid_at')
                            ->label(Str::upper(__('Paid At')))
                            ->content(function ($get) {
                                return (empty($get('paid_at'))) ? '-' : Carbon::parse($get('paid_at'))->format('d-m-Y h:i:s');
                            }),
                        Placeholder::make('status')
                            ->label(Str::upper(__('Status')))
                            ->content(function ($get) {
                                // dd($get('status'), $get('status') == PaymentStatusEnum::PAID->value);
                                switch ($get('status')) {
                                    case (PaymentStatusEnum::UNPAID->value):
                                    default:
                                        $color = 'bg-danger-100 text-danger-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-danger-900 dark:text-danger-300';
                                        $text = Str::upper(PaymentStatusEnum::UNPAID->value);
                                        break;
                                    case (PaymentStatusEnum::PAID->value):
                                        $color = 'bg-success-100 text-success-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-success-900 dark:text-success-300';
                                        $text = Str::upper(PaymentStatusEnum::PAID->value);
                                        break;
                                }
                                return new HtmlString('<span class="font-semibold ' . $color . '">' . $text . '</span>');
                            }),
                        FileUpload::make('payment_receipt')
                            ->label(__('Payment Receipt'))
                            ->image()
                            ->previewable()
                            ->downloadable()
                            ->minSize(512)
                            ->maxSize(1024),
                        //->moveFiles()
                        //->disk('local')
                        //->directory('transaction-payments'),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if (!$user->hasRole(RoleEnum::SUPER_ADMIN->value) && !$user->hasRole(RoleEnum::ADMIN->value)) {
                    //$query->select('*, clinic_user.clinic_id, clinic_user.id AS c_user_id');
                    $query->select('transactions.*');
                    $query->leftJoin('appointments', 'appointments.id', '=', 'appointment_id');
                    $query->leftJoin('clinic_user', 'clinic_user.id', '=', 'appointments.clinic_user_id');
                    $query->where('clinic_user.clinic_id', $user->clinics()->first()->id);
                    clock()->info($query->toRawSql());
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('appointment.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient_age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('doctor_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('amount_treatments')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('amount_prescriptions')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('amount_total')
                    ->label(__('Total Bill'))
                    ->money('IDR')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('payment_receipt')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::upper($state->value))
                    ->color(fn (object $state): string => match ($state) {
                        PaymentStatusEnum::UNPAID => 'danger',
                        PaymentStatusEnum::PAID => 'success',
                    }),
                // Tables\Columns\TextColumn::make('paid_at')
                //     ->dateTime()
                //     ->sortable(),
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
                Tables\Actions\Action::make('pdf')
                    ->label('Download Invoice')
                    ->color('success')
                    ->icon('tabler-download')
                    ->action(function (Model $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf', ['record' => $record])
                            )->stream();
                        }, $record->id . '.pdf');
                    }),
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
            BillsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
