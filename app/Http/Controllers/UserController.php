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

        // Tentukan roles berdasarkan route
        $roles = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        $query = User::query();
        if ($roles === 'petugas') {
            $query->where('roles', 'petugas');
        }

        $users = $query->when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

        $view = $roles === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList';

        return view($view, compact('users', 'search'));
    }

    /**
     * Show the form for creating a new user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        $roles = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $view = $roles === 'petugas' ? 'petugas.create' : 'admin.createEmployee';

        return view($view);
    }

    /**
     * Store a newly created user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $roles = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $roles === 'petugas' ? 'petugas' : ($request->roles ?? 'admin'),
            'password' => bcrypt($request->password),
        ]);

        $redirect = $roles === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList';

        return redirect()->route($redirect)
            ->with('success', ucfirst($roles) . ' berhasil ditambahkan.');
    }

    /**
     * Show a specific user
     *
     * @param \App\Models\User $user
     */
    public function show(User $user)
    {
        $roles = str_contains(request()->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $view = $roles === 'petugas' ? 'petugas.show' : 'admin.showEmployee';

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
        $roles = str_contains($request->route()->getName(), 'petugas') ? 'petugas' : 'admin';

        if ($roles === 'petugas' && $employeeList->roles !== 'petugas') {
            abort(403);
        }

        $view = $roles === 'petugas' ? 'petugas.edit' : 'admin.editEmployee';
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
        $roles = str_contains(request()->route()->getName(), 'petugas') ? 'petugas' : 'admin';
        $user = User::findOrFail($employeeList);

        // Kalau user mencoba hapus dirinya sendiri
        if (Auth::id() == $employeeList) {
            return redirect()
                ->route('admin.employeeList.index')
                ->with('error', 'Anda tidak bisa menghapus akun yang sedang digunakan!');
        }

        if ($roles === 'petugas' && $employeeList->roles !== 'petugas') {
            abort(403);
        }

        $user->delete();
        $redirect = $roles === 'petugas' ? 'petugas.dashboard' : 'admin.employeeList.index';

        return redirect()->route($redirect)
            ->with('success', ucfirst($roles) . ' berhasil dihapus.');
    }
}
