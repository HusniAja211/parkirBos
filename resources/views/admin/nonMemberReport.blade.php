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
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">Token</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">Kategori</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">Check In</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">Check Out</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-white">Bills (Rp)</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-white">Cash (Rp)</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-white">Change (Rp)</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-white">Petugas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                  @forelse($payments as $payment)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $payments->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> {{ optional($payment->parking)->token ?? '-' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> {{ optional($payment)->kategori ?? '-' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> {{ optional($payment->parking)->check_in ? optional($payment->parking)->check_in->format('Y-m-d H:i') : '-' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> {{ optional($payment->parking)->check_out ? optional($payment->parking)->check_out->format('Y-m-d H:i') : '-' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> Rp {{ number_format($payment->cash ?? 0, 0, ',', '.') }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> Rp {{ number_format($payment->change ?? 0, 0, ',', '.') }} </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"> {{ $payment->petugas->name ?? '-' }} </td>
                       
                    </tr>
                    @empty
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Data Kosong!</td>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                <div class="text-xs text-slate-500">Menampilkan {{ $payments->count(0) }} dari {{ $payments->total() }}</div>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</div>

@include('components.footer')