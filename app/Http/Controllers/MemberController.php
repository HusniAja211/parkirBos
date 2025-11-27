<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Status;
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
        // Validasi Data
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16', 'unique:members,nik'],
            'email' => ['required', 'email:rfc,dns', 'max:100', 'unique:members,email'],
        ]);

        $status = Status::where('name', 'lunas')->firstOrFail();
        
        // Masukkan ke Database
        Member::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->name,
            'status_id' => Status::where('name', 'lunas')->value('id'),
        ]);
        return redirect()
        ->route('petugas.member.index')
        ->with('success', 'Member berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::findOrFail($id);
        $statuses = Status::all();

        return view('petugas.member.edit', compact('member', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

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
