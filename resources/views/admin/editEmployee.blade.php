@include('components.header', ['title' => 'Edit Petugas Baru'])

<div class="max-w-2xl mx-auto">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm text-slate-500">
        <a href="{{ route('admin.employeeList.index') }}" class="hover:text-blue-600 transition">Petugas</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Edit</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-slate-200">
        <div class="px-6 py-4 bg-blue-600 border-b border-blue-500">
            <h2 class="text-lg font-semibold text-white">Edit Data Petugas</h2>
            <p class="text-blue-100 text-xs mt-1">Perbarui informasi akun petugas di bawah ini.</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('admin.employeeList.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                        Email Address
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                           required>
                </div>

                <!-- Username -->
                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                        Username
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                           required>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                        Password (kosongkan jika tidak ingin diganti)
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           minlength="8" maxlength="8"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition">
                </div>

                <!-- Button -->
                <div class="pt-4 flex justify-end">
                    <button type="submit" 
                            class="py-2 px-6 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.footer')
