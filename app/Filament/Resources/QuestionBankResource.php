<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionBankResource\Pages;
use App\Models\QuestionBank;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | \UnitEnum | null $navigationGroup = 'Pembelajaran';

    protected static ?string $navigationLabel = 'Bank Soal';

    protected static ?string $modelLabel = 'Soal';

    protected static ?string $pluralModelLabel = 'Bank Soal';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Soal')
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label('Mata Kuliah')
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('question_type')
                            ->label('Tipe Soal')
                            ->options([
                                'multiple_choice' => 'Pilihan Ganda',
                                'essay' => 'Essay',
                                'true_false' => 'Benar / Salah',
                            ])
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('difficulty')
                            ->label('Tingkat Kesulitan')
                            ->options([
                                'easy' => 'Mudah',
                                'medium' => 'Sedang',
                                'hard' => 'Sulit',
                            ])
                            ->required()
                            ->default('medium'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),

                Section::make('Pertanyaan & Jawaban')
                    ->schema([
                        Forms\Components\Textarea::make('question')
                            ->label('Pertanyaan')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('options')
                            ->label('Opsi Jawaban')
                            ->simple(
                                Forms\Components\TextInput::make('option')
                                    ->required(),
                            )
                            ->minItems(4)
                            ->maxItems(6)
                            ->default(['', '', '', ''])
                            ->visible(fn ($get) => $get('question_type') === 'multiple_choice')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('answer_key')
                            ->label('Kunci Jawaban')
                            ->required()
                            ->rows(2)
                            ->helperText(fn ($get) => match ($get('question_type')) {
                                'multiple_choice' => 'Masukkan teks jawaban yang benar (harus sama persis dengan salah satu opsi)',
                                'true_false' => 'Masukkan: Benar atau Salah',
                                'essay' => 'Masukkan kunci jawaban atau rubrik penilaian',
                                default => '',
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Kuliah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('question_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'multiple_choice' => 'info',
                        'essay' => 'warning',
                        'true_false' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'multiple_choice' => 'Pilihan Ganda',
                        'essay' => 'Essay',
                        'true_false' => 'Benar/Salah',
                    }),

                Tables\Columns\TextColumn::make('difficulty')
                    ->label('Kesulitan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'easy' => 'Mudah',
                        'medium' => 'Sedang',
                        'hard' => 'Sulit',
                    }),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Pembuat')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Mata Kuliah')
                    ->relationship('subject', 'name'),

                Tables\Filters\SelectFilter::make('question_type')
                    ->label('Tipe Soal')
                    ->options([
                        'multiple_choice' => 'Pilihan Ganda',
                        'essay' => 'Essay',
                        'true_false' => 'Benar/Salah',
                    ]),

                Tables\Filters\SelectFilter::make('difficulty')
                    ->label('Kesulitan')
                    ->options([
                        'easy' => 'Mudah',
                        'medium' => 'Sedang',
                        'hard' => 'Sulit',
                    ]),
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
            'index' => Pages\ListQuestionBanks::route('/'),
            'create' => Pages\CreateQuestionBank::route('/create'),
            'edit' => Pages\EditQuestionBank::route('/{record}/edit'),
        ];
    }
}
