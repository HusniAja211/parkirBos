<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyBill extends Model
{
    protected $fillable = [
        'month',
        'amount',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'member_id', 'member_id')
                    ->latest('created_at');
    }
}
