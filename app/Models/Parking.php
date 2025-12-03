<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Parking extends Model
{

    protected $fillable = [
        'token',
        'member_id',
        'check_in',
        'check_out',
        'total_fee',
        'qr_code',
    ];

     // Laravel otomatis konversi timestamp ke Carbon
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

        // Durasi parkir dalam menit
    public function getDurationAttribute()
    {
        if (!$this->check_out) return null;
        return $this->check_out->diffInMinutes($this->check_in);
    }

    // Durasi parkir format jam & menit
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return null;

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        return "{$hours} jam {$minutes} menit";
    }

    // Hitung total fee, misal rate per jam 5000
   public function calculateFee()
    {
        if (!$this->duration) return 0;

        // Durasi dalam menit → ubah ke jam, dibulatkan ke atas
        $hours = ceil($this->duration / 60);

        // Tentukan tarif sesuai tipe kendaraan
        if ($this->kategori === 'mobil') {
            $baseRate = 3000 * 2;   // 3.000 x 2
            $extraRate = 2000 * 2;  // 2.000 x 2
            $maxFee = 10000 * 2;    // 10.000 x 2
        } else { // motor
            $baseRate = 3000;
            $extraRate = 2000;
            $maxFee = 10000;
        }

        $baseHours = 3; // 3 jam pertama

        if ($hours <= $baseHours) {
            $fee = $baseRate;
        } else {
            $extraHours = $hours - $baseHours;
            $fee = $baseRate + ($extraHours * $extraRate);
        }

        return min($fee, $maxFee);
    }

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
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
