@include('components.header', ['title' => 'Scan Member'])

<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Scan Kartu Member</h2>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('petugas.processMemberScan') }}" method="POST" class="space-y-4">
        @csrf
        <label class="block font-medium text-slate-700">Member ID / Scan QR:</label>
        <input type="number" name="member_id" placeholder="Masukkan ID member" required
            class="w-full border border-slate-300 rounded-lg p-3 focus:ring focus:ring-blue-200 focus:border-blue-600" />

        <button type="submit"
            class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Lanjut Bayar
        </button>
    </form>
</div>

@include('components.footer')
