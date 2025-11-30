<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{

    protected $fillable = [
        'token',
        'kategori',
        'check_in',
        'check_out',
        'total_fee',

    ];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function petugas()
    {
        return $this->hasOne(User::class);
    }
}
