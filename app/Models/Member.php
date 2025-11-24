<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'amount',
        'cash',
        'chage',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
