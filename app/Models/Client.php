<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $table = 'client';

    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'interest',
        'date_of_birth',
        'email',
        'account',
        'credit_card_type',
        'credit_card_number',
        'credit_card_name',
        'credit_card_expirationDate',
        'hash',
        'credit_card_identical_digits',
    ];
}
