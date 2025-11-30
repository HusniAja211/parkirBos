@include('components.header', ['title' => 'Laporan Pembayaran Member'])

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Member</h1>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi transaksi pembayaran langganan member.</p>
        </div>
         <a href="{{ route('petugas.member.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Member
        </a>
    </div>

    <!--Search & Content -->
        <form method="GET" action="{{ route('petugas.member.index') }}" class="mb-4 flex gap-2">
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
                <a href="{{ route('petugas.member.index') }}" 
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                   @forelse ($members as $member)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $member->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $member->nik}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $member->email}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $member->status->name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            <a href="{{ route('petugas.member.edit', $member->id) }}" class="text-amber-600 hover:text-amber-800 font-medium transition">Update</a>
                            <span class="text-slate-300">|</span>
                             <form action="{{ route('petugas.member.destroy', $member->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="text-red-600 hover:text-red-800 font-medium delete-btn">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 text-left">Data Kosong!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            <div class="text-xs text-slate-500">Menampilkan {{ $members->count() }} dari {{ $members->total() }}</div>
        </div>
        {{ $members->links() }}
    </div>
</div>

@include('components.footer')
