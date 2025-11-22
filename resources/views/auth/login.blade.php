<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    @vite('resources/css/app.css')

    <!-- Menggunakan font Inter dari CDN Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan latar belakang yang sama dengan parkir.blade.php */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Biru muda/abu-abu sangat terang */
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Kontainer Login (Meniru Card Kiri Parkir Page) -->
    <!-- Lebar diperbesar dari max-w-md menjadi max-w-xl -->
    <div class="w-full max-w-xl bg-white rounded-xl shadow-2xl p-8 sm:p-10 space-y-6">

        <!-- Header -->
        <header class="text-center space-y-2 mb-6">
            <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight">
                Login
            </h1>
            <p class="text-gray-500">
                Akses ke Sistem Parkir
            </p>
        </header>

        <!-- Session Status (Pesan Berhasil) -->
        @if (session('status'))
            <div class="p-3 bg-blue-100 border border-blue-300 text-blue-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <!-- Menggantikan x-input-label -->
                <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email</label>
                <!-- Menggantikan x-text-input dengan style dari parkir page -->
                <input 
                    id="email" 
                    class="w-full py-2.5 px-4 text-gray-800 bg-white border border-blue-400 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition placeholder-gray-400 text-base" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username" 
                />
                <!-- Error Handling (Mempertahankan logika Laravel) -->
                @error('email')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <!-- Menggantikan x-input-label -->
                <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>

                <!-- Menggantikan x-text-input dengan style dari parkir page -->
                <input 
                    id="password" 
                    class="w-full py-2.5 px-4 text-gray-800 bg-white border border-blue-400 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition placeholder-gray-400 text-base"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                />

                <!-- Error Handling (Mempertahankan logika Laravel) -->
                @error('password')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Tombol dan Link -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-4 sm:space-y-0">
               
                <!-- Link Register -->
                <a class="underline text-sm text-gray-600 hover:text-blue-700 transition"
                       href="{{ route('register') }}">
                        {{ __("Don't have an account?") }}
                </a>    

                <div class="flex items-center space-x-3">
                    
                    <!-- Link Forgot Password -->
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-blue-700 transition" 
                        href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <!-- Tombol Login (Menggantikan x-primary-button dengan style Cetak Karcis) -->
                    <button type="submit" class="ms-3 py-2.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold text-base rounded-xl transition duration-300 shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-blue-400 uppercase">
                        {{ __('Log in') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</body>
</html>