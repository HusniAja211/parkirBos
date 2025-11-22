<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Parking</title>
    <!-- Asumsi Anda menggunakan Vite untuk Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Menggunakan font Inter dari CDN Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* Gaya kustom: Menggunakan warna dasar putih/biru muda untuk tampilan modern & bersih */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Biru muda/abu-abu sangat terang */
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Kontainer Utama: Menggunakan Grid untuk 2 Kolom yang Berdampingan -->
    <!-- max-w-5xl untuk memberikan ruang yang cukup, dan shadow besar -->
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-7 bg-white rounded-xl shadow-2xl overflow-hidden">
        
        <!-- CARD KIRI (Fitur Utama: Lebih dominan, 4/7 lebar di desktop) -->
        <div class="p-6 sm:p-10 space-y-8 lg:col-span-4 bg-white">
            
            <!-- Header -->
            <header class="text-center space-y-2">
                <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight uppercase">
                    ParkirBos!
                </h1>
                <p class="text-gray-600 text-lg">
                    Sistem Otomatis - Ambil Karcis Masuk
                </p>
            </header>

            <!-- Bagian Instruksi dan Button Print -->
            <div class="bg-blue-50 p-5 rounded-xl border border-blue-200 space-y-4 text-center">
                <p class="text-gray-700 text-base font-medium">
                    <span class="font-semibold text-blue-600">Instruksi Masuk:</span> Tekan tombol di bawah untuk mencetak karcis masuk Anda.
                </p>
                <button 
                    id="printButton" 
                    class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl rounded-xl transition duration-300 shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-blue-400 uppercase"
                >
                    Cetak Karcis
                </button>
                <p class="text-blue-500 text-xs pt-2">
                    * Mohon tunggu sejenak, karcis akan keluar secara otomatis.
                </p>
            </div>

            <!-- Divider Scan / Ambil Karcis -->
            <div class="flex items-center space-x-2">
                <span class="flex-grow border-t border-gray-300"></span>
                <span class="text-gray-500 text-sm font-medium uppercase">Atau Pindai</span>
                <span class="flex-grow border-t border-gray-300"></span>
            </div>

            <!-- Bagian Input Scan Kode -->
            <section class="space-y-4">
                <p class="text-gray-700 text-base font-light text-center">
                    <span class="text-blue-600 font-semibold">Instruksi Scan:</span> Masukkan atau pindai kode QR/tiket untuk verifikasi.
                </p>
                
                <div class="relative">
                    <input 
                        type="text" 
                        id="scanInput"
                        placeholder="Masukkan atau pindai kode tiket di sini..." 
                        class="w-full py-3 pl-4 pr-12 text-gray-800 bg-white border-2 border-blue-400 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition placeholder-gray-400 text-base"
                        autofocus
                        onkeyup="handleScan(event)"
                    >
                    <!-- Ikon Scanner -->
                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10m16-10v10M6 10h12M6 14h12M9 5v14m6-14v14" />
                    </svg>
                </div>
                
                <div id="messageBox" class="text-center p-3 rounded-lg text-sm transition duration-300 hidden font-medium"></div>
            </section>

        </div>

        <!-- CARD KANAN (Visual / Gambar: 3/7 lebar di desktop) -->
        <!-- Bagian ini akan disembunyikan di layar kecil (mobile) -->
        <div class="hidden lg:flex lg:col-span-3 bg-blue-700 p-8 items-center justify-center flex-col text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Sistem Parkir Modern</h2>
            <!-- Gambar Placeholder Parkir (menggunakan ikon SVG/gambar sederhana) -->
            <img 
                src="https://placehold.co/400x400/3b82f6/ffffff?text=PARKING" 
                alt="Ilustrasi Parkir Digital" 
                class="w-full h-auto max-w-[300px] rounded-lg shadow-xl"
                onerror="this.onerror=null; this.src='https://placehold.co/400x400/3b82f6/ffffff?text=PARKING';"
            >
            <p class="mt-6 text-blue-200 text-sm">
                Pelayanan cepat dan terintegrasi untuk kenyamanan Anda.
            </p>
        </div>

    </div>

    <!-- Script JavaScript untuk interaktivitas sederhana -->
    <script>
        const scanInput = document.getElementById('scanInput');
        const printButton = document.getElementById('printButton');
        const messageBox = document.getElementById('messageBox');

        // Fungsi untuk menampilkan pesan status
        function showMessage(text, isError = false) {
            messageBox.textContent = text;
            messageBox.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
            if (isError) {
                messageBox.classList.add('bg-red-100', 'text-red-700');
                messageBox.classList.remove('bg-blue-100', 'text-blue-700');
            } else {
                messageBox.classList.add('bg-blue-100', 'text-blue-700');
                messageBox.classList.remove('bg-red-100', 'text-red-700');
            }
            setTimeout(() => {
                 messageBox.classList.add('hidden');
            }, 3000);
        }

        // Handler untuk tombol "Cetak Karcis"
        printButton.addEventListener('click', () => {
            // Logika simulasi cetak karcis (misalnya, panggil API endpoint)
            console.log('Permintaan cetak karcis terkirim...');
            showMessage('Karcis masuk sedang dicetak. Silakan ambil!', false);
        });

        // Handler untuk input scan kode
        function handleScan(event) {
            if (event.key === 'Enter') {
                const code = scanInput.value.trim();
                scanInput.value = ''; // Kosongkan input setelah di-scan/input

                if (code) {
                    // Logika simulasi verifikasi kode
                    console.log('Kode terdeteksi:', code);
                    if (code.length > 5 && code.startsWith('TKT')) { // Contoh verifikasi yang lebih spesifik
                        showMessage(`Kode Tiket '${code}' berhasil diverifikasi. Selamat Jalan!`, false);
                    } else {
                        showMessage(`Kode Tiket '${code}' tidak valid atau sudah kedaluwarsa.`, true);
                    }
                }
            }
        }
        
        // Pastikan input selalu fokus untuk perangkat scanner/keyboard
        scanInput.focus();
        // Menambahkan event listener pada body untuk mengembalikan fokus ke input
        document.body.addEventListener('click', () => {
            if (document.activeElement !== scanInput) {
                scanInput.focus();
            }
        });
        document.body.addEventListener('touchstart', () => {
            if (document.activeElement !== scanInput) {
                scanInput.focus();
            }
        });

    </script>
</body>
</html>