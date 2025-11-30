<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'cash',
        'change',
        'type',
        'petugas_id'
        
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
}
