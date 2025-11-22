@include('components.header', ['title' => 'Daftar Petugas'])

<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Petugas</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data akun petugas yang terdaftar.</p>
        </div>
        <a href="{{ route('admin.createEmployee') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Petugas
        </a>
    </div>

    {{-- Search & Content --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div class="w-full max-w-xs relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" placeholder="Cari username atau email..." class="pl-10 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm transition duration-150 ease-in-out">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-800 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-800 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-800 uppercase tracking-wider">Username</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-800 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    {{-- Loop Data Petugas (Contoh Statis) --}}
                    @for ($i = 1; $i <= 5; $i++)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">{{ $i }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-700 font-medium">petugas{{ $i }}@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">user_petugas_{{ $i }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            <button class="text-amber-600 hover:text-amber-800 font-medium transition">Update</button>
                            <span class="text-slate-300">|</span>
                            <button class="text-red-600 hover:text-red-800 font-medium transition">Delete</button>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        {{-- Pagination Placeholder --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            <div class="text-xs text-slate-500">Menampilkan 5 dari 20 data</div>
        </div>
    </div>
</div>

@include('components.footer')