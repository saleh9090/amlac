<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('contract_number')
                    ->label('Contract #')
                    ->required(),
                Select::make('tenant_id')
                    ->relationship('tenant', 'name')
                    ->required(),
                Select::make('unit_id')
                    ->relationship('unit', 'unit_number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Each unit can only have one contract.'),
                DatePicker::make('start_date')
                    ->label('Start')
                    ->required(),
                TextInput::make('duration_months')
                    ->label('Duration(M)')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                DatePicker::make('end_date')
                    ->label('End')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Calculated automatically from start date + duration months - 1 day.'),
                TextInput::make('rent_amount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_frequency')
                    ->label('Frequency')
                    ->options([
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->default('monthly')
                    ->required(),
                Select::make('payment_method')
                    ->label('Method')
                    ->options([
                        'bank_transfer' => 'Bank transfer',
                        'cheque' => 'Cheque',
                        'cash' => 'Cash',
                    ])
                    ->default('bank_transfer')
                    ->required(),
                TextInput::make('status')
                    ->disabled()
                    ->dehydrated(false)
                    ->default('active')
                    ->helperText('Calculated automatically: Active until the end date expires, then Inactive.'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                FileUpload::make('contract_image')
                    ->label('Contract PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('local')
                    ->directory('contracts')
                    ->maxFiles(1)
                    ->columnSpanFull(),
            ]);
    }
}
