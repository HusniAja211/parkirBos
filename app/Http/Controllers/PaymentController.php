<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Parking;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $payments = Payment::with([
        'monthlyBill.member',
            'employee'
        ])->latest()->paginate(5);

        return view('admin.memberReport', compact('payments'));
    }

    public function checkout(Parking $parking)
    {
        // Hitung total biaya jika belum dihitung
        if (!$parking->total_fee) {
            $parking->total_fee = $this->calculateFee($parking);
        }

        return view('petugas.checkout', compact('parking'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Parking $parking)
    {
        $request->validate([
            'cash' => 'required|numeric|min:' . $parking->total_fee,
        ]);

         $cash = $request->cash;
        $change = $cash - $parking->total_fee;

        // Simpan data ke tabel payments
        Payment::create([
            'parking_id' => $parking->id,
            'petugas_id' => Auth::id(),
            'amount'     => $parking->total_fee,
            'cash'       => $cash,
            'change'     => $change,
            'type'       => 'non_member',
        ]);

        // Update parking agar check_out tidak bisa dipakai lagi
        $parking->update([
            'check_out' => now(),
        ]);

        return redirect()->route('petugas.checkout.show', $parking->id)
            ->with('success', 'Pembayaran Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function calculateFee(Parking $parking)
    {
        $jamMasuk = strtotime($parking->check_in);
        $jamKeluar = strtotime($parking->check_out ?? now());
        $selisihJam = ceil(($jamKeluar - $jamMasuk) / 3600);

        if ($selisihJam <= 1) return 3000;

        return 3000 + (($selisihJam - 1) * 2000);
    }
}
