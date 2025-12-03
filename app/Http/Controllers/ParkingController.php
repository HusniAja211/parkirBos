<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\Member;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Parking::query();
        $parkings = $query->when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('nik', 'like', '%{search}%');
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

        return view('petugas.parking', compact('parkings', 'search'));
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
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|integer|exists:members,id',
        ]);

        // Jika member → lakukan pengecekan status
        if ($request->member_id) {
            $this->ensureMemberIsPaid($request->member_id);
        }

        // Buat data parking (token/ID + save DB)
        $parking = $this->createParkingRecord($request->member_id);

        // Generate QR dan update DB
        $this->generateQrForParking($parking);

        // GENERATE PDF
        $pdf = Pdf::loadView('petugas.ticket', compact('parking'));

        // Download langsung
        return $pdf->download('tiket_parkir_'.$parking->id.'.pdf');

        $pdf->save(storage_path('app/public/tickets/tiket_'.$parking->id.'.pdf'));

        return redirect()->back()->with('success', 'Karcis berhasil dibuat!');
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

    /**
     * To check if members paid their monthly_bills or not
     */
    private function ensureMemberIsPaid($memberId)
    {
        $member = Member::with('status')->findOrFail($memberId);

        if ($member->status->name !== 'lunas') {
            abort(403, 'Member belum melunasi tagihan.');
        }
    }

    /**
     * To create record for parkings
     */
    private function createParkingRecord($memberId)
    {
        if (!$memberId) {
            $last = Parking::orderBy('id', 'desc')->value('id') ?? 0;
            $nextNumber = $last + 1;
            $token = 'PRK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        } else {
            $token = null;
        }

        return Parking::create([
            'token'     => $token,
            'member_id' => $memberId ?: null,
            'check_in'  => now(),
            'check_out' => null,
            'total_fee' => 0,
        ]);
    }

    /**
     * To generate qrcodes
     */
    private function generateQrForParking(Parking $parking)
    {
        $qrContent = (string) $parking->id;
        $qrPath = public_path('qrcodes_tickets');

        if (!file_exists($qrPath)) {
            mkdir($qrPath, 0755, true);
        }

        $fileName = "{$parking->id}.png";
        $fileFullPath = $qrPath . '/' . $fileName;

        $builder = new Builder(
            writer: new PngWriter(),
            data: $qrContent,
            size: 400,
            margin: 10
        );

        $builder->build()->saveToFile($fileFullPath);

        $parking->update([
            'qr_code' => $fileName
        ]);
    }
}
