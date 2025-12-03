<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Parking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Member;
use App\Models\MonthlyBill;
use App\Models\Status;

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
        ])
        ->whereNotNull('member_id')
        ->latest()
        ->paginate(5);

        return view('admin.memberReport', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("petugas.scanout");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parking_id'    => 'required|integer|exists:parkings,id',
            'cash'          => 'nullable|numeric|min:0', // hanya untuk non-member
            'kategori'      => 'required|in:motor,mobil',
            'license_plate' => 'required|regex:/^[A-Z][0-9]{1,4}[A-Z]{1,3}$/i',
        ]);

        // Ambil parking
        $parking = Parking::with('member', 'payment')->findOrFail($request->parking_id);

        // Cek sudah bayar
        if ($parking->payment) {
            return back()->with('error', 'Parkir ini sudah melakukan pembayaran!');
        }

        $license_plate = $request->license_plate;
        $kategori      = $request->kategori;
        $totalFee      = $parking->calculateFee($kategori);

        // Tentukan tipe dan kembalian
        if ($parking->member_id) {
            // MEMBER
            if ($parking->member->status->nama === 'belum_lunas') {
                return back()->with('error', 'Member belum melunasi tagihan.');
            }
            $type     = 'member';
            $memberId = $parking->member_id;
            $cash     = $totalFee;
            $change   = 0;
        } else {
            // NON MEMBER
            $type     = 'non_member';
            $memberId = null;
            $cash     = $request->cash;

            if ($cash < $totalFee) {
                return back()->with('error', "Uang tidak mencukupi! Total: Rp ".number_format($totalFee));
            }
            $change = $cash - $totalFee;
        }

        // Simpan payment
        $payment = Payment::create([
            'parking_id'    => $parking->id,
            'member_id'     => $memberId,
            'petugas_id'    => Auth::id(),
            'amount'        => $totalFee,
            'cash'          => $cash,
            'change'        => $change,
            'type'          => $type,
            'kategori'      => $kategori,
            'license_plate' => $license_plate,
        ]);

        // Update check_out
        $parking->update([
            'check_out' => now(),
            'total_fee' => $totalFee,
        ]);

        // Generate PDF struk
        $pdf = Pdf::loadView('petugas.invoice', [
            'parking' => $parking,
            'payment' => $payment,
        ]);

        return $pdf->download('struk_parkir_'.$parking->id.'.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parking $parking)
    {
        return view('petugas.checkout', compact('parking'));
    }

    public function checkOut(Parking $parking)
    {
        // Set check_out sekarang
        $parking->check_out = now();

        // Hitung total fee
        $parking->total_fee = $parking->calculateFee();
        $parking->save();

        return view('petugas.checkout', compact('parking'));
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

    public function processScan(Request $request)
    {
        $request->validate(['parking_id' => 'required|integer|exists:parkings,id']);

        $parking = Parking::find($request->parking_id);

        if (!$parking) {
            return back()->with('error', 'Parkir tidak ditemukan!');
        }

        return redirect()->route('petugas.checkout.show', $parking->id);
    }

    public function scanMemberForm()
    {
        return view('petugas.scanMember'); // halaman scan kartu / ID member
    }

    public function processMemberScan(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::with('status', 'monthlyBills')->findOrFail($request->member_id);

        // Format bulan sekarang: YYYY-MM
        $currentMonth = now()->format('Y-m');

        // Ambil atau buat tagihan bulan ini
        $monthlyBill = MonthlyBill::firstOrCreate(
            ['member_id' => $member->id, 'month' => $currentMonth],
            ['amount' => 150000, 'status' => 'belum_lunas']
        );

        return view('petugas.memberPayment', compact('member', 'monthlyBill'));
    }

    // ===============================
    // 3. Proses pembayaran member
    // ===============================
    public function payMember(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::with('status', 'monthlyBills')->findOrFail($request->member_id);
        $currentMonth = now()->format('Y-m');
        $monthlyBill = MonthlyBill::where('member_id', $member->id)
                            ->where('month', $currentMonth)
                            ->firstOrFail();

        if ($monthlyBill->status === 'lunas') {
            return back()->with('error', 'Tagihan bulan ini sudah lunas.');
        }

        $amount = $monthlyBill->amount;

        // Simpan payment
        $payment = Payment::create([
            'member_id' => $member->id,
            'monthly_bill_id'  => $monthlyBill->id,
            'petugas_id' => Auth::id(),
            'amount' => $amount,
            'cash' => $amount,
            'change' => 0,
            'type' => 'member',
            'kategori' => 'pembayaran_member',
            'license_plate' => 'null',
        ]);

        // Update monthly_bill menjadi lunas
        $monthlyBill->update(['status' => 'lunas']);

        // Update status member
        $lunasStatus = Status::where('name', 'lunas')->first();
        if ($lunasStatus) {
            $member->update(['status_id' => $lunasStatus->id]);
        }

        return redirect()->route('petugas.memberPayment')
                         ->with('success', 'Pembayaran bulan ini berhasil!');
    }
}
