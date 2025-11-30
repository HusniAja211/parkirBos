<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

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
            'kategori' => 'required|in:motor,mobil',
            'member_id' => 'nullable|integer|exists:members,id',
        ]);

        $memberId = $request->member_id;

        // ====== 1. Jika NON MEMBER → Generate Token ======
        if (!$memberId) {
            // Ambil ID terakhir untuk membuat token berikutnya
            $last = Parking::orderBy('id', 'desc')->value('id') ?? 0;

            $nextNumber = $last + 1;

            // Format: PRK00001
            $token = 'PRK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $memberId = null; // pastikan null
        } else {
            // ====== 2. Jika MEMBER ======
            $token = null;
        }

        // ====== 3. Simpan ke DB ======
        $parking = Parking::create([
            'token'     => $token,
            'member_id' => $memberId,
            'kategori'  => $request->kategori,
            'check_in'  => now(),
            'check_out' => null,
            'total_fee' => 0,
        ]);

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
}
