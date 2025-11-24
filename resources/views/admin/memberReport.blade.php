@include('components.header', ['title' => 'Laporan Pembayaran Member'])

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Member</h1>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi transaksi pembayaran langganan member.</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print to PDF
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="bg-blue-600">
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">No Plat</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Months</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Bills (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Cash (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Change (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Employee Name</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                   @forelse ($bills as $bill)
                    @php
                        $latestPayment = $bill->member->payments->sortByDesc('created_at')->first();
                    @endphp
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $bill->member->license_plate }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $bill->member->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-semibold">{{ $bill->month }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Rp {{ $latestPayment?->amount ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Rp {{ $latestPayment?->cash ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Rp {{ $latestPayment?->change ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $latestPayment?->petugas->name ?? '-' }}</td>
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
            <div class="text-xs text-slate-500">Menampilkan {{ $bills->count() }} dari {{ $bills->total() }}</div>
        </div>
        {{ $bills->links() }}
    </div>
</div>

@include('components.footer')
