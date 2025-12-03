<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Digital Parking</title>
        <!-- Menggunakan font Inter dari CDN Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
        <style>
            /* Gaya kustom: Menggunakan warna dasar putih/biru muda untuk tampilan modern & bersih */
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f0f4f8; /* Biru muda/abu-abu sangat terang */
            }
        </style>
    </head>
    <body class="flex min-h-screen items-center justify-center p-4">
        <!-- Kontainer Utama: Menggunakan Grid untuk 2 Kolom yang Berdampingan -->
        <!-- max-w-5xl untuk memberikan ruang yang cukup, dan shadow besar -->
        <div class="grid w-full max-w-5xl grid-cols-1 overflow-hidden rounded-xl bg-white shadow-2xl lg:grid-cols-7">
            <!-- CARD KIRI (Fitur Utama: Lebih dominan, 4/7 lebar di desktop) -->
            <div class="space-y-8 bg-white p-6 sm:p-10 lg:col-span-4">
                <!-- Header -->
                <header class="space-y-2 text-center">
                    <h1 class="text-3xl font-extrabold uppercase tracking-tight text-blue-800">ParkirBos!</h1>
                    <p class="text-lg text-gray-600">Sistem Otomatis - Ambil Karcis Masuk</p>
                </header>

                <!-- Bagian Instruksi dan Button Print -->
                <div class="space-y-4 rounded-xl border border-blue-200 bg-blue-50 p-5 text-center">
                    <p class="text-base font-medium text-gray-700">
                        <span class="font-semibold text-blue-600">
                            Instruksi Masuk:
                            <br />
                        </span>
                        Tekan tombol di bawah untuk mencetak karcis masuk Anda.
                    </p>
                    <!-- BUTTON CETAK KARCIS -->
                    <form id="parkingForm" action="{{ route('petugas.parking.store') }}" method="POST">
                        @csrf
                        <button
                            id="printButton"
                            class="w-full transform rounded-xl bg-blue-600 px-6 py-3 text-xl font-bold uppercase text-white shadow-lg shadow-blue-300/50 transition duration-300 hover:scale-[1.01] hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 active:scale-[0.99]"
                        >
                            Cetak Karcis
                        </button>
                        <!-- Loading -->
                        <p class="pt-2 text-xs text-blue-500">
                            * Mohon tunggu sejenak, karcis akan keluar secara otomatis.
                        </p>
                    </form>
                </div>

                <!-- Divider Scan / Ambil Karcis -->
                <div class="flex items-center space-x-2">
                    <span class="flex-grow border-t border-gray-300"></span>
                    <span class="text-sm font-medium uppercase text-gray-500">Atau Pindai</span>
                    <span class="flex-grow border-t border-gray-300"></span>
                </div>

                <!-- Bagian Input Scan Kode -->
                <form id="scan-form" action="{{ route('petugas.parking.store') }}" method="POST">
                    @csrf
                    <section class="space-y-4">
                        <p class="text-center text-base font-light text-gray-700">
                            <span class="font-semibold text-blue-600">Instruksi Scan:</span>
                            Masukkan atau pindai kode QR/tiket untuk verifikasi.
                        </p>
                        <div class="relative">
                            <input
                                type="text"
                                id="member_id"
                                name="member_id"
                                placeholder="Masukkan atau pindai kode tiket di sini..."
                                class="w-full rounded-xl border-2 border-blue-400 bg-white py-3 pl-4 pr-12 text-base text-gray-800 placeholder-gray-400 transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                autofocus
                                autocomplete="off"/>
                            <!-- Ikon Scanner -->
                            <svg
                                class="absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 transform text-blue-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 7v10m16-10v10M6 10h12M6 14h12M9 5v14m6-14v14"
                                />
                            </svg>
                        </div>

                        <div
                            id="messageBox"
                            class="hidden rounded-lg p-3 text-center text-sm font-medium transition duration-300"
                        ></div>
                    </section>
                </form>
            </div>

            <!-- CARD KANAN (Visual / Gambar: 3/7 lebar di desktop) -->
            <!-- Bagian ini akan disembunyikan di layar kecil (mobile) -->
            <div class="hidden flex-col items-center justify-center bg-blue-700 p-8 text-center lg:col-span-3 lg:flex">
                <h2 class="mb-4 text-2xl font-bold text-white">Sistem Parkir Modern</h2>
                <!-- Gambar Placeholder Parkir (menggunakan ikon SVG/gambar sederhana) -->
                <img
                    src="https://placehold.co/400x400/3b82f6/ffffff?text=PARKING"
                    alt="Ilustrasi Parkir Digital"
                    class="h-auto w-full max-w-[300px] rounded-lg shadow-xl"
                    onerror="
                        this.onerror = null
                        this.src = 'https://placehold.co/400x400/3b82f6/ffffff?text=PARKING'
                    "
                />
                <p class="mt-6 text-sm text-blue-200">Pelayanan cepat dan terintegrasi untuk kenyamanan Anda.</p>
            </div>
        </div>
    </body>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/sweetalert2.js'])
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessAlert("{{ session('success') }}")
            })
        </script>
    @endif
</html>
