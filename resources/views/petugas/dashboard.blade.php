@include('components.header', ['title' => 'Daftar Petugas'])

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Petugas</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data akun petugas yang terdaftar.</p>
        </div>
        
    </div>

    <!--Search & Content -->
        <form method="GET" action="{{ route('admin.employeeList.index') }}" class="mb-4 flex gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Cari nama atau email..." 
            class="border rounded px-3 py-2 w-64 focus:outline-none focus:ring focus:ring-blue-300">

            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('admin.employeeList.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Reset
                </a>
            @endif
        </form>

        <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="bg-blue-600">
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-700 font-medium">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">{{ $user->roles }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <a href="{{ route('admin.employeeList.edit', $user->id) }}" class="text-amber-600 hover:text-amber-800 font-medium transition">Update</a>
                                <span class="text-slate-300">|</span>
                                @if(auth()->id() != $user->id)
                                <form action="{{ route('admin.employeeList.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800 font-medium delete-btn">
                                        Delete
                                    </button>
                                </form>
                                @else
                                <span class="text-slate-400 italic text-sm">Sedang login</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">Data Kosong!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination Placeholder -->
        <div class="px-6 py-4 border-t bg-white">
            <div class="text-xs text-slate-500">{{ $users->links() }}</div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    showSuccessAlert("{{ session('success') }}");
});
</script>
@endif

@include('components.footer')