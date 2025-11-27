@include('components.header', ['title' => 'Tambah Petugas Baru'])

<div class="max-w-2xl mx-auto">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm text-slate-500">
        <a href="{{ route('admin.employeeList.index') }}" class="hover:text-blue-600 transition">Petugas</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Create</span>
    </nav>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-slate-200">
        <div class="px-6 py-4 bg-blue-600 border-b border-blue-500">
            <h2 class="text-lg font-semibold text-white">Registrasi Petugas Baru</h2>
            <p class="text-blue-100 text-xs mt-1">Isi formulir di bawah ini untuk menambahkan akses petugas.</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('admin.employee.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="nama@gmail.com" required>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="johndoe123" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="••••••••" required minlength="8" maxlength="8">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="••••••••" required minlength="8" maxlength="8">
                </div>

                <div class="pt-4 flex items-center justify-end space-x-4">
                    <a href="{{ url('admin/petugas') }}" class="text-sm text-slate-500 hover:text-slate-800 font-medium transition">Batal</a>
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Daftarkan Petugas
                    </button>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 p-2 text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

            </form>
        </div>
    </div>
</div>

@include('components.footer')