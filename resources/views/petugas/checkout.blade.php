@include('components.header', ['title' => 'Checkout Pembayaran'])

<div class="mx-auto mt-10 max-w-lg rounded-2xl bg-white p-6 shadow-lg">
    <h2 class="mb-6 text-center text-3xl font-bold text-slate-800">Checkout Pembayaran</h2>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if (session('error'))
        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- DATA PARKIR --}}
    <div id="parkingData" data-duration="{{ $parking->duration }}"></div>

    {{-- DETAIL PARKING --}}
    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-4">
        <h3 class="mb-2 text-xl font-semibold text-blue-800">Detail Parkir</h3>

        <p class="text-slate-700"><strong>ID Parkir:</strong> {{ $parking->id }}</p>
        <p class="text-slate-700"><strong>Waktu Masuk:</strong> {{ $parking->check_in->format('H:i') }}</p>
        <p class="text-slate-700"><strong>Waktu Keluar:</strong> {{ $parking->check_out->format('H:i') }}</p>
        <p class="text-slate-700"><strong>Durasi Parkir:</strong> {{ $parking->formatted_duration }}</p>
        <p class="text-slate-700"><strong>Total Biaya:</strong> <span id="totalFee" class="font-bold text-blue-700">Rp 0</span></p>
    </div>

    {{-- FORM PEMBAYARAN --}}
    <form action="{{ route('petugas.payment.store') }}" method="POST" class="space-y-4">
        @csrf

        <label class="block font-medium text-slate-700">Kategori Kendaraan:</label>
        <select name="kategori" id="kategori" class="w-full rounded-lg border border-slate-300 p-3 text-lg transition focus:border-blue-600 focus:ring focus:ring-blue-200" 
        required>
            <option value="">-- Pilih Kategori --</option>
            <option value="motor">Motor</option>
            <option value="mobil">Mobil</option>
        </select>

        <label class="block font-medium text-slate-700">License Plate:</label>
        <input type="text" name="license_plate" class="w-full rounded-lg border border-slate-300 p-3 text-lg transition focus:border-blue-600 focus:ring focus:ring-blue-200" 
        placeholder="B1234XYZ tanpa spasi" required/>

        @if(!$parking->member_id)
        <!-- Hanya untuk non member -->
        <label class="block font-medium text-slate-700">Uang Diterima (Cash):</label>
        <input type="number" name="cash" class="w-full rounded-lg border border-slate-300 p-3 text-lg transition focus:border-blue-600 focus:ring focus:ring-blue-200" 
        placeholder="Masukkan uang tunai" required/>
        @endif

        <input type="hidden" name="parking_id" value="{{ $parking->id }}" />
        <button class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white shadow transition hover:bg-blue-700">
            Bayar Sekarang
        </button>
    </form>
</div>

@vite('resources/js/checkout.js')
@include('components.footer')
