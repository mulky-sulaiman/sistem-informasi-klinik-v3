<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Filament\Resources\AppointmentResource\RelationManagers\PrescriptionsRelationManager;
use App\Filament\Resources\AppointmentResource\RelationManagers\TreatmentsRelationManager;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected $listeners = ['refreshAppointment' => '$refresh'];

    protected static ?string $navigationIcon = 'tabler-calendar-clock';

    // protected static ?string $modelLabel = 'employee';
    // protected static ?string $pluralModelLabel = 'employees';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Appointment Data'))
                    // ->label('Clinic\'s Basic Info')
                    ->description(__('Contains patient\'s data and their diagnostic info'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'name')
                            // ->hintAction(
                            //     Action::make('patient')
                            //         ->label('Patient\'s Detail')
                            //         ->icon('tabler-eye')
                            //         ->form([
                            //             Placeholder::make('name'),
                            //         ])->action(function (Set $set) {
                            //             // do something
                            //         })
                            // )
                            ->hint(
                                function ($get) {
                                    return new HtmlString('<a href="/admin/patients/' . $get('patient_id') . '" target="_blank">Patient\'s Detail</a>');
                                }
                            )
                            // ->createOptionForm([
                            //     Section::make('New Patient')
                            //         //->label('Employee\'s Basic Info')
                            //         ->schema([
                            //             Forms\Components\TextInput::make('name')
                            //                 ->required(),
                            //             Forms\Components\TextInput::make('phone')
                            //                 ->required()
                            //                 ->tel(),
                            //         ])
                            // ])
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('clinic_user_id')
                            ->label(__('Clinic : Doctor'))
                            ->relationship('clinic_doctor', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->clinic()->first()->name} : {$record->user()->first()->name}")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('schedule_date')
                            ->required(),
                        Forms\Components\TextInput::make('height')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('weight')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('blood_pressure')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('symptoms')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make(__('Appointment Status'))
                    // ->label('Patient\'s Domicile')
                    ->description(__('Marking steps of the Appointment\'s process'))
                    ->columnSpan(1)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        Radio::make('status')
                            ->options([
                                AppointmentStatusEnum::SCHEDULED->value => Str::upper(AppointmentStatusEnum::SCHEDULED->label()),
                                AppointmentStatusEnum::DIAGNOSED->value => Str::upper(AppointmentStatusEnum::DIAGNOSED->label()),
                                AppointmentStatusEnum::PREPARED->value => Str::upper(AppointmentStatusEnum::PREPARED->label()),
                                AppointmentStatusEnum::CONFIRMED->value => Str::upper(AppointmentStatusEnum::CONFIRMED->label()),
                            ])
                            ->descriptions([
                                AppointmentStatusEnum::SCHEDULED->value => __('Initial status. Marked by Clinic\'s Operator'),
                                AppointmentStatusEnum::DIAGNOSED->value => __('Status when patient has finished being diagnosed. Marked by Clinic\'s Doctor'),
                                AppointmentStatusEnum::PREPARED->value => __('Status when the prescriptions has finished being prepared. Marked by Clinic\'s Pharmacist'),
                                AppointmentStatusEnum::CONFIRMED->value => __('Final status when everything has confirmed. Would also generate Transaction & Bill once set. Marked by Clinic\'s Operator'),
                            ])
                            ->live(),
                    ]),
                Section::make('')
                    //->label('Clinic\'s Basic Info')
                    //->description('Contains default data to be used as authentication to the system')
                    ->columnSpan(3)
                    ->columns(3)
                    ->schema([
                        Forms\Components\Textarea::make('diagnostic')
                            ->columnSpanFull(),
                    ]),

            ])->columns(3);;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if (!$user->hasRole(RoleEnum::SUPER_ADMIN->value) && !$user->hasRole(RoleEnum::ADMIN->value)) {
                    //$query->select('*, clinic_user.clinic_id, clinic_user.id AS c_user_id');
                    $query->select('appointments.*');
                    $query->leftJoin('clinic_user', 'clinic_user.id', '=', 'clinic_user_id');
                    $query->where('clinic_user.clinic_id', $user->clinics()->first()->id);
                    clock()->info($query->toRawSql());
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Appointment')
                    ->numeric()
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clinic_user.clinic.name')
                    ->label('Clinic')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.name')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clinic_user.user.name')
                    ->label('Doctor')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('clinic_user_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('schedule_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('blood_pressure')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::upper($state->value))
                    ->color(fn (object $state): string => match ($state) {
                        AppointmentStatusEnum::SCHEDULED => 'info',
                        AppointmentStatusEnum::DIAGNOSED => 'primary',
                        AppointmentStatusEnum::PREPARED => 'warning',
                        AppointmentStatusEnum::CONFIRMED => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        AppointmentStatusEnum::SCHEDULED->value => Str::upper(AppointmentStatusEnum::SCHEDULED->label()),
                        AppointmentStatusEnum::DIAGNOSED->value => Str::upper(AppointmentStatusEnum::DIAGNOSED->label()),
                        AppointmentStatusEnum::PREPARED->value => Str::upper(AppointmentStatusEnum::PREPARED->label()),
                        AppointmentStatusEnum::CONFIRMED->value => Str::upper(AppointmentStatusEnum::CONFIRMED->label()),
                    ]),
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
            TreatmentsRelationManager::class,
            PrescriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
