<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyBill extends Model
{
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
