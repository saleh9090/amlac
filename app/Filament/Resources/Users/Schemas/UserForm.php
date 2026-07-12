<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->maxLength(255)
                    ->helperText('Leave blank to keep the current password.'),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->default('admin')
                    ->required()
                    ->helperText('Admin can view and edit everything. User can only view — and only the building(s) assigned below.'),
                Select::make('buildings')
                    ->relationship('buildings', 'name')
                    ->multiple()
                    ->preload()
                    ->helperText('Which building(s) this user can access. Ignored for Admins, who always see everything.'),
            ]);
    }
}
