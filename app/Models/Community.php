<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'name',
        'min_amount',
        'total_amount',
    ];

    // Relationship with members
    public function members()
{
    return $this->hasMany(Member::class);
}

}
