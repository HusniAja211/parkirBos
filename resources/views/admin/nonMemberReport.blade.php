@include('components.header', ['title' => 'Laporan Pembayaran Non-Member'])

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Non-Member</h1>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi transaksi pembayaran tamu (non-member).</p>
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Token</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Bills (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Cash (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Change (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Employee Name</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    {{-- Dummy Data --}}
                    @foreach([
                        ['B 1234 CD', 'TKN-001', '15.000', '20.000', '5.000', 'Budi Santoso'],
                        ['D 5678 EF', 'TKN-002', '10.000', '10.000', '0', 'Siti Aminah'],
                        ['L 9999 GH', 'TKN-003', '25.000', '50.000', '25.000', 'Budi Santoso'],
                    ] as $row)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $row[0] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono bg-slate-50 w-min rounded">{{ $row[1] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $row[2] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $row[3] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">{{ $row[4] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $row[5] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50 font-semibold text-slate-700">
                    <tr>
                        <td colspan="2" class="px-6 py-3">Total: Rp50.000,00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@include('components.footer')