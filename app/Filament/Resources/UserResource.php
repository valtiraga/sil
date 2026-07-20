<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.data_master');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.user');
    }

    public static function getModelLabel(): string
    {
        return __('nav.user.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.user.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('user.section_info'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('common.full_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label(__('common.email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label(__('common.password'))
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state) => filled($state))
                            ->minLength(8)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label(__('common.role'))
                            ->options([
                                'admin' => 'Admin',
                                'dosen' => __('common.role_lecturer'),
                                'mahasiswa' => __('common.role_student'),
                            ])
                            ->required()
                            ->default('admin'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('common.active_status'))
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('common.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('common.email'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label(__('common.role'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'dosen' => 'warning',
                        'mahasiswa' => 'success',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('common.active'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->label(__('user.last_login'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder(__('user.never_logged_in')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label(__('common.role'))
                    ->options([
                        'admin' => 'Admin',
                        'dosen' => __('common.role_lecturer'),
                        'mahasiswa' => __('common.role_student'),
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('common.active_status')),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
