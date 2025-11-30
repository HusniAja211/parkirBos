<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Status;
use Illuminate\Validation\Rule;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $members = Member::latest()->paginate(5);
       return view('petugas.member', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.createMember');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'nik'   => ['required', 'digits:16', 'unique:members,nik'],
            'email' => ['required', 'email:rfc,dns', 'max:100', 'unique:members,email'],
        ]);

        $member = Member::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'status_id' => Status::where('name', 'lunas')->value('id')
        ]);

        // Folder QR
        $qrPath = public_path('qrcodes');
        if (!file_exists($qrPath)) {
            mkdir($qrPath, 0755, true);
        }

        $fileName = "{$member->id}.png";
        $fileFullPath = $qrPath . '/' . $fileName;

        // Generate QR Code
        $builder = new Builder(
            writer: new PngWriter(),
            data: $member->id,
            size: 400,
            margin: 10
        );

        $result = $builder->build();
        $result->saveToFile($fileFullPath);

        // Update DB
        $member->update([
            'qr_code' => $fileName
        ]);

        return redirect()
            ->route('petugas.member.index')
            ->with('success', 'Member berhasil didaftarkan & QR berhasil dibuat!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);
        $statuses = Status::all();

        return view('petugas.editMember', compact('member', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16', Rule::unique('members', 'nik')->ignore($member->id)],
            'email' => ['required', 'email:rfc,dns', 'max:100', Rule::unique('members', 'email')->ignore($member->id)],
        ]);

        $member->name = $request->name;
        $member->nik = $request->nik;
        $member->email = $request->email;

        $member->save();

        return redirect()
            ->route('petugas.member.index')
            ->with('success', 'Data member berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);

        $member->delete();
        return redirect()
            ->route('petugas.member.index')
            ->with('success', 'Data member berhasil Dihapus!');
    }
}
