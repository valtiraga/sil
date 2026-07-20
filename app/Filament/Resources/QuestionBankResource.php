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

    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group.learning');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.question_bank');
    }

    public static function getModelLabel(): string
    {
        return __('nav.question_bank.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.question_bank.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('question.section_info'))
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label(__('common.subject'))
                            ->relationship('subject', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('question_type')
                            ->label(__('question.type'))
                            ->options([
                                'multiple_choice' => __('question.type_mc'),
                                'essay' => __('question.type_essay'),
                                'true_false' => __('question.type_tf'),
                            ])
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('difficulty')
                            ->label(__('question.difficulty'))
                            ->options([
                                'easy' => __('question.diff_easy'),
                                'medium' => __('question.diff_medium'),
                                'hard' => __('question.diff_hard'),
                            ])
                            ->required()
                            ->default('medium'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('common.active'))
                            ->default(true),
                    ])->columns(2),

                Section::make(__('question.section_qa'))
                    ->schema([
                        Forms\Components\Textarea::make('question')
                            ->label(__('question.text'))
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('options')
                            ->label(__('question.options'))
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
                            ->label(__('question.answer_key'))
                            ->required()
                            ->rows(2)
                            ->helperText(fn ($get) => match ($get('question_type')) {
                                'multiple_choice' => __('question.helper_mc'),
                                'true_false' => __('question.helper_tf'),
                                'essay' => __('question.helper_essay'),
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
                    ->label(__('common.subject'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('question')
                    ->label(__('question.text'))
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('question_type')
                    ->label(__('question.type_short'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'multiple_choice' => 'info',
                        'essay' => 'warning',
                        'true_false' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'multiple_choice' => __('question.type_mc'),
                        'essay' => __('question.type_essay'),
                        'true_false' => __('question.type_tf'),
                    }),

                Tables\Columns\TextColumn::make('difficulty')
                    ->label(__('question.difficulty_short'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'easy' => __('question.diff_easy'),
                        'medium' => __('question.diff_medium'),
                        'hard' => __('question.diff_hard'),
                    }),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label(__('common.creator'))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('common.active'))
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label(__('common.subject'))
                    ->relationship('subject', 'name'),

                Tables\Filters\SelectFilter::make('question_type')
                    ->label(__('question.type'))
                    ->options([
                        'multiple_choice' => __('question.type_mc'),
                        'essay' => __('question.type_essay'),
                        'true_false' => __('question.type_tf'),
                    ]),

                Tables\Filters\SelectFilter::make('difficulty')
                    ->label(__('question.difficulty_short'))
                    ->options([
                        'easy' => __('question.diff_easy'),
                        'medium' => __('question.diff_medium'),
                        'hard' => __('question.diff_hard'),
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
