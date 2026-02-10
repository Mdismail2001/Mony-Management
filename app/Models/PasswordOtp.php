<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordOtp extends Model
{
    use HasFactory;

    // Your table is named "password_otps"
    protected $table = 'password_otps';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'email',
        'phone_number',
        'otp',
        'expires_at',
    ];

    // So Carbon can handle expires_at
    protected $dates = ['expires_at'];
}
