<?php

namespace App\Filament\Resources;

use delete;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Admin & Employees Managment';
    protected static ?string $navigationLabel = 'Admin';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Card::make()
                        ->schema([
                            TextInput::make('name')->label('Username')->maxLength(50)->required(),
                TextInput::make('email')->email()->label('Email Address')->required()->unique(),
                TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255)
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                // Toggle::make('isAdmin')->label('Affecte Admin')->inline(false),
                        ])
                        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                ToggleColumn::make('isAdmin')->label('Affecte Admin')->onColor('success')
                ->offColor('danger'),
                TextColumn::make('created_at'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('delete')
                ->action(fn (User $record) => $record->delete())
                ->requiresConfirmation(),
                

                /*-------------------NOT WORKING------------------------*/
                
                // Action::make('delete ')
                // ->action(fn () => $this->record->delete())
                // ->requiresConfirmation()
                // ->modalHeading('Delete User')
                // ->modalSubheading('Are you sure you\'d like to delete these User? This cannot be undone.')
                // ->modalButton('Yes, delete User')

                 /*-------------------------------------------*/
                    
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
