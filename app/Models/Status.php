<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];

    protected $attributes = [
        'status_id' => 1,
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
