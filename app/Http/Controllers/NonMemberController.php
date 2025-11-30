<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\Payment;

class NonMemberController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['parking', 'petugas'])
            ->where('type', 'non_member')
            ->latest()              
            ->paginate(10);         

        return view('admin.nonMemberReport', compact('payments'));
    }
}
