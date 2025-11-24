<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users (admin & petugas)
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // Tentukan role berdasarkan route
        $role = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        $query = User::query();
        if ($role === 'petugas') {
            $query->where('role', 'petugas');
        }

        $users = $query->when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

        $view = $role === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList';

        return view($view, compact('users', 'search'));
    }

    /**
     * Show the form for creating a new user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        $role = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $view = $role === 'petugas' ? 'petugas.create' : 'admin.createEmployee';

        return view($view);
    }

    /**
     * Store a newly created user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $role = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $role === 'petugas' ? 'petugas' : ($request->role ?? 'admin'),
            'password' => bcrypt($request->password),
        ]);

        $redirect = $role === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList';

        return redirect()->route($redirect)
            ->with('success', ucfirst($role) . ' berhasil ditambahkan.');
    }

    /**
     * Show a specific user
     *
     * @param \App\Models\User $user
     */
    public function show(User $user)
    {
        $role = str_contains(request()->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $view = $role === 'petugas' ? 'petugas.show' : 'admin.showEmployee';

        return view($view, compact('user'));
    }

    /**
     * Show the form for editing a user
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     */
    public function edit(Request $request, User $employeeList)
    {
        $role = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        if ($role === 'petugas' && $employeeList->role !== 'petugas') {
            abort(403);
        }

        $view = $role === 'petugas' ? 'petugas.edit' : 'admin.editEmployee';
        return view($view, ['user' => $employeeList]);
    }

    /**
     * Update a user
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()
            ->route('admin.employeeList.index')
            ->with('success', 'Data petugas berhasil diperbarui!');
    }

    /**
     * Delete a user
     *
     * @param \App\Models\User $user
     */

    public function destroy($employeeList)
    {
        $role = str_contains(request()->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $user = User::findOrFail($employeeList);

        // Kalau user mencoba hapus dirinya sendiri
        if (Auth::id() == $employeeList) {
            return redirect()
                ->route('admin.employeeList.index')
                ->with('error', 'Anda tidak bisa menghapus akun yang sedang digunakan!');
        }

        if ($role === 'petugas' && $employeeList->role !== 'petugas') {
            abort(403);
        }

        $user->delete();
        $redirect = $role === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList.index';

        return redirect()->route($redirect)
            ->with('success', ucfirst($role) . ' berhasil dihapus.');
    }
}
