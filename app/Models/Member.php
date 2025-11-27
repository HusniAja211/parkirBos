<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'name',
        'nik',
        'email',
        'status_id',
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
