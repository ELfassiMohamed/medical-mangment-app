<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Client;
use App\Models\ClientRecord;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ClientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientResource\Pages\EditClient;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Filament\Resources\ClientResource\Pages\ListClients;
use App\Filament\Resources\ClientResource\Pages\CreateClient;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Clients & Records';
    protected static ?string $navigationLabel = 'Clients';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('first_name')->label('First Name')->maxLength(50)->required(), 
                    TextInput::make('last_name')->label('Last Name')->maxLength(50)->required(),
                    DatePicker::make('birth_date')->label('Birth Date')->required(),
                    Textarea::make('address')->label('Address')->rows(2)->required(),
                    TextInput::make('phone')->label('Phone Number')->prefix('+212')->tel()->required(),
                    TextInput::make('email')->label('Email Address')->email(),
                    Radio::make('sexe')->label('Client Gender : ')->options([
                        'sexe1' => 'Male',
                        'sexe2' => 'Female',
                                            
                    ])->columns(2)->inline(),
                    Radio::make('clients_status')->label('Client Status : ')->options([
                        'C1' => 'Still Active',
                        'C2' => 'Finished',
                                            
                    ])
                    ->descriptions([
                        'C1' => 'Still an active client',
                        'C2' => 'not an active client',
                        
                    ])
                    ->columns(2)->inline()
    
   
                                            
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('Client First Name'),
                TextColumn::make('last_name')->label('Client Last Name'),
                TextColumn::make('sexe')->label('Client Gender')->enum([
                    'sexe1' => 'Male',
                    'sexe2' => 'Female',
                ]) ->size('lg'),
                TextColumn::make('clients_status')->label('Client Status')->enum([
                    'C1' => 'Still Active',
                    'C2' => 'Finished', 
                ]) ->size('lg'),
                TextColumn::make('created_at'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                CreateAction::make()
                ->label('Client Record')
                            ->model(ClientRecord::class)
                            ->form([
                                Repeater::make('members')
                                    ->schema([
            //   Probleme          Select::make('client_id')->relationship('client_record', 'first_name'),
                                TextInput::make('operation_type')->maxLength(50)->required(),
                                DatePicker::make('operation_date')->required(),   
                                TextInput::make('operation_cost')->maxLength(50)->required(),
                                Radio::make('isPayed')
                                        ->label('Do you like this post?')
                                        ->boolean()
                                    ])
                                    ->columns(2)
                            ])
                
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }    
}
