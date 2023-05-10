<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'number',
        'complement',
        'district',
        'cep',
        'uf',
        'locality',
        'user_id'
    ];
}
