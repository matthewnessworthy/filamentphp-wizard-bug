<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Builder::make('content_blocks')
                    ->blocks([
                        Block::make('widget')
                            ->schema([
                                Wizard::make([
                                    Step::make('Widget')
                                        ->schema([
                                            Radio::make('widget')
                                                ->options(
                                                    [
                                                        'widget-1' => 'Widget 1',
                                                        'widget-2' => 'Widget 2',
                                                    ]
                                                ),
                                        ]),
                                    Step::make('Fields')
                                        ->schema(
                                            function (Get $get) {
                                                $widget = (string) $get('widget');

                                                return match ($widget) {
                                                    'widget-1' => [
                                                        Select::make('broken-js-select-box')
                                                            ->multiple()
                                                            ->options([
                                                                'option-1' => 'Option 1',
                                                                'option-2' => 'Option 2',
                                                                'option-3' => 'Option 3',
                                                            ]),
                                                        TextInput::make('widget-1-text'),
                                                    ],
                                                    default => [
                                                        TextInput::make('widget-2-text'),
                                                    ],
                                                };
                                            }
                                        ),
                                ]),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
