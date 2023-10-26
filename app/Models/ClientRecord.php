<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRecord extends Model
{
    use HasFactory;

    protected $fillable = ['client_id',
    'operation_type',
    'operation_date',
    'operation_cost',
    'isPayed',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
