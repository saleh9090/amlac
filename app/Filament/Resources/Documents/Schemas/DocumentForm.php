<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Building;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('building_id')
                    ->label('Building')
                    ->relationship('building', 'name')
                    ->default(fn (): ?int => Building::query()->where('name', 'AlGobrah')->value('id'))
                    ->required(),
                FileUpload::make('file_path')
                    ->label('PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('local')
                    ->directory('documents')
                    ->maxFiles(1)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
