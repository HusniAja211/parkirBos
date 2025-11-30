@include('components.header', ['title' => 'Laporan Parkir'])

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Member</h1>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi Parkir</p>
        </div>
         <a href="{{ route('petugas.member.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Member
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="bg-blue-600">
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Token</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Total Fee</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                   @forelse ($parkings as $parking)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-800">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-800">{{ $parking->token }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-800">{{ $parking->member->name ?? 'non member'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-600">{{ $parking->kategori}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-600">{{ $parking->check_in}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-600">{{ $parking->check_out ?? 'Belum keluar'}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center text-slate-600">{{ $parking->total_fee}}</td>
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
            <div class="text-xs text-slate-500">Menampilkan {{ $parkings->count() }} dari {{ $parkings->total() }}</div>
        </div>
        {{ $parkings->links() }}
    </div>
</div>

@include('components.footer')
