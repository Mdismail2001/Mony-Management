<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'name',
        'min_amount',
        'total_amount',
        'banking_info', // allow mass assignment
    ];
    // Cast JSON to array automatically
    protected $casts = [
        'banking_info' => 'array',
    ];

    // Relationship with members
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'members')
            ->withPivot('role', 'total_amount', 'last_payment')
            ->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }



}
