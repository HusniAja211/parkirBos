<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class NonMemberController extends Controller
{
    public function index()
    {
        $parkings = Parking::with(['payment.petugas'])
            ->whereHas('payment', function($q) {
                $q->where('type', 'non_member'); // ambil parkings yg punya pembayaran non-member
            })
            ->latest()
            ->paginate(5);

        return view('admin.nonMemberReport', compact('parkings'));
    }
}
