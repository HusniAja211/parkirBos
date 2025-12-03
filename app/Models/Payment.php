<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'parking_id',
        'member_id',
        'monthly_bill_id',
        'amount',
        'cash',
        'change',
        'type',
        'petugas_id',
        'kategori',
        'license_plate'
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function monthlyBill()
    {
        return $this->belongsTo(MonthlyBill::class, 'monthly_bill_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
