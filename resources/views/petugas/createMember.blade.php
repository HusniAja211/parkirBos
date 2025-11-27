@include('components.header', ['title' => 'Tambah Petugas Baru'])

<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-slate-200">
        <div class="px-6 py-4 bg-blue-600 border-b border-blue-500">
            <h2 class="text-lg font-semibold text-white">New Member registration</h2>
            <p class="text-blue-100 text-xs mt-1">Fill out the form below to add a new member.</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('petugas.member.store') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="Insert Your Name" required>
                </div>
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-slate-700 mb-1">NIK</label>
                    <input type="text" name="nik" id="nik" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="Insert Your NIK" minlength="16" maxlength="16" required>
                </div>
                 <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                    placeholder="Insert Your Email" required>
                </div>
                <!-- Button Register dan Cancel-->
                <div class="pt-4 flex items-center justify-end space-x-4">
                    <a href="{{ url('admin/petugas') }}" class="text-sm text-slate-500 hover:text-slate-800 font-medium transition">Cancel</a>
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Register A Member
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

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    showSuccessAlert("{{ session('success') }}");
});
</script>
@endif

@include('components.footer')