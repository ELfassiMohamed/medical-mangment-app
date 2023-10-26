<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['first_name',
    'last_name',
    'sexe',
    'address',
    'date_hired',
    'birth_date',
    'clients_status',
    'phone',
    'email'];

    public function client_record() {
        return $this->hasMany(ClientRecord::class);
    }
}
