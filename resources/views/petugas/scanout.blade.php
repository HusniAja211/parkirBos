@include('components.header', ['title' => 'Scan Out Pembayaran'])

<div class="max-w-lg mx-auto bg-white shadow-lg p-6 rounded-2xl mt-10">

    <h2 class="text-3xl font-bold text-center text-slate-800 mb-6">
        Scan Out Pembayaran
    </h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('petugas.payment.processScan') }}" method="POST" id="scanForm">        
        @csrf
        <label class="block font-medium text-slate-700">Hasil Scan Tiket:</label>
        <input 
            type="number" 
            name="parking_id" 
            id="scanInput"
            class="w-full border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition p-3 rounded-lg text-lg tracking-widest"
            placeholder="Arahkan scanner ke sini..."
            autofocus
            required>
            <br>
        <button 
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-lg w-full shadow transition">
            Proses Scan Out
        </button>
    </form>
</div>

<script>
// Auto submit jika scanner mengirim "Enter" di akhir string
document.getElementById('scanInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        this.form.submit();
    }
});
</script>

@include('components.footer')
