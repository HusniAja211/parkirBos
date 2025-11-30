@include('components.header', ['title' => 'Laporan Pembayaran Member'])

<div class="max-w-lg mx-auto bg-white shadow-lg p-6 rounded-2xl mt-8">

    <h2 class="text-3xl font-bold mb-6 text-center text-slate-800">
        Checkout Non Member
    </h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-2 mb-6 text-slate-700">
        <p class="flex justify-between"><span class="font-semibold">Token:</span> <span>{{ $parking->token }}</span></p>
        <p class="flex justify-between"><span class="font-semibold">No Plat:</span> <span>{{ $parking->license_plate }}</span></p>
        <p class="flex justify-between"><span class="font-semibold">Kategori:</span> <span>{{ ucfirst($parking->kategori) }}</span></p>
        <p class="flex justify-between"><span class="font-semibold">Check In:</span> <span>{{ $parking->check_in }}</span></p>
        <p class="flex justify-between"><span class="font-semibold">Check Out:</span> <span>{{ $parking->check_out ?? now() }}</span></p>
        <p class="flex justify-between text-lg">
            <span class="font-bold">Total Biaya:</span>
            <span class="font-bold text-blue-600">Rp {{ number_format($parking->total_fee, 0, ',', '.') }}</span>
        </p>
    </div>

    <form action="{{ route('petugas.checkout.store', $parking->id) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1 text-slate-700">Uang Tunai:</label>
            <input type="number" 
                   name="cash" 
                   class="w-full border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition p-3 rounded-lg"
                   required>
            @error('cash')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-4 py-3 rounded-lg w-full shadow">
            Bayar Sekarang
        </button>
    </form>

</div>

@include('components.footer')
