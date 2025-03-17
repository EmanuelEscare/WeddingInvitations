<?php

namespace App\Filament\Resources;

use App\Enums\GuestAgeGroup;
use App\Filament\Resources\InvitationResource\Pages;
use App\Filament\Resources\InvitationResource\RelationManagers;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    public static function getPluralModelLabel(): string
    {
        return  __('Invitations');
    }

    public static function getModelLabel(): string
    {
        return __('Invitation');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        TextInput::make('invitation_url')
                            ->label(__('Invitation Link'))
                            ->default(fn($record) => $record?->invitation_url)
                            ->disabled()
                            ->extraAttributes(['readonly' => true])
                            ->suffixAction(
                                fn($record) => Action::make('copy')
                                    ->label(__('Copy'))
                                    ->icon('heroicon-o-clipboard')
                                    ->action(function ($livewire, $state) {
                                        $livewire->js(<<<JS
                                        window.navigator.clipboard.writeText("{$state}");
                                    JS);

                                        Notification::make()
                                            ->title(__('Invitation copied'))
                                            ->success()
                                            ->send();
                                    })
                            )
                            ->visible(fn($record) => $record !== null)
                            ->columnSpan(12),

                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),

                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpan(6),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(15)
                            ->nullable()
                            ->columnSpan(6),

                        Section::make(__('Invitations'))
                            ->schema([
                                Repeater::make('guests')
                                    ->label('')
                                    ->relationship('guests')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nombre')
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('age_group')
                                            ->label('Grupo de edad')
                                            ->options(GuestAgeGroup::class)
                                            ->default(GuestAgeGroup::adult->value)
                                            ->required(),

                                        Toggle::make('confirmation')
                                            ->label(__('Confirmation'))
                                            ->disabled(true)
                                    ])
                                    ->minItems(1)
                                    ->reorderableWithDragAndDrop(true)
                                    ->columnSpan(12)
                                    ->collapsed()
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->sortable()->searchable(),
                TextColumn::make('email')->label('Correo')->searchable(),
                TextColumn::make('phone')->label('Teléfono'),
                TextColumn::make('invitation_url')
                    ->label(__('Invitation'))
                    ->badge()
                    ->copyable()
                    ->copyMessage(__('Invitation copied'))
                    ->copyMessageDuration(1500)
                    ->state(__('Copy link'))
                    ->copyableState(fn($record): string => "URL: {$record->invitation_url}")
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInvitations::route('/'),
            'create' => Pages\CreateInvitation::route('/create'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
