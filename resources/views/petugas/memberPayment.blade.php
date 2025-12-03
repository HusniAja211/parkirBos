@include('components.header', ['title' => 'Pembayaran Bulanan Member'])

<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Pembayaran Bulanan</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    <div class="mb-6 border border-blue-200 rounded-xl bg-blue-50 p-4">
        <p><strong>Nama Member:</strong> {{ $member->name }}</p>
        <p><strong>Bulan Tagihan:</strong> {{ $monthlyBill->month }}</p>
        <p><strong>Jumlah Tagihan:</strong> Rp {{ number_format($monthlyBill->amount) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($monthlyBill->status) }}</p>
    </div>

    @if($monthlyBill->status === 'belum_lunas')
    <form action="{{ route('petugas.payMember') }}" method="POST">
        @csrf
        <input type="hidden" name="member_id" value="{{ $member->id }}" />
        <button type="submit"
            class="w-full bg-green-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Bayar Sekarang
        </button>
    </form>
    @else
        <div class="text-center text-gray-700 font-semibold">Tagihan bulan ini sudah lunas.</div>
    @endif
</div>

@include('components.footer')
