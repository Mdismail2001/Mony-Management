<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'community_id',
        'amount',
        'date',
        'proof',
        'month',
        'verified_by',
        'verified_at',
        'reason_for_rejection',
        'status',
    ];

    // A transaction belongs to a member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // A transaction belongs to a community
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    // Verify admin -> user table
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
