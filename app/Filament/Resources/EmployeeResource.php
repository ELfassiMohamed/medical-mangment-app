<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\Pages\EditEmployee;
use App\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use App\Filament\Resources\EmployeeResource\Pages\CreateEmployee;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Admin & Employees Managment';
    protected static ?string $navigationLabel = 'Employees';
    protected static ?int $navigationSort = 2;

    

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
                    DatePicker::make('date_hired')->label('Date of Hirring')->required(),
                    Select::make('role')->label('Employee Role')->options([
                        'R1' => '1st Doctor',
                        'R2' => 'Nurse',
                        'R3' => 'Intern',
                    ]),
                    Radio::make('employee_status')->label('Employee Status : ')->options([
                        'S1' => 'Active',
                        'S2' => 'Hold',
                        'S3' => 'Dismissed',                      
                    ])
                    ->descriptions([
                        'S1' => 'Still Working',
                        'S2' => 'Mau or Not Working',
                        'S3' => 'Do not Active', 
                    ])
                    ->columns(3)->inline()
    
   
                                            
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
       
        return $table
            ->columns([
                TextColumn::make('first_name')->label('Employee First Name'),
                TextColumn::make('last_name')->label('Employee Last Name'),
                TextColumn::make('employee_status')->label('Employee Status')->enum([
                        'S1' => 'Active',
                        'S2' => 'Hold',
                        'S3' => 'Dismissed',  
                ]) ->size('lg'),
                TextColumn::make('role')->label('Employee Role')->enum([
                        'R1' => '1st Doctor',
                        'R2' => 'Nurse',
                        'R3' => 'Intern',
                ]) ->size('lg'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }    
}
