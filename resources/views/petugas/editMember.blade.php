@include('components.header', ['title' => 'Edit Petugas Baru'])

<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-slate-200">
        <div class="px-6 py-4 bg-blue-600 border-b border-blue-500">
            <h2 class="text-lg font-semibold text-white">Edit Member Data</h2>
            <p class="text-blue-100 text-xs mt-1">Update Member account information below</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('admin.employeeList.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- License Plate -->
                <div>
                    <label for="license_plate" class="block text-sm font-medium text-slate-700 mb-1">
                        License Plate
                    </label>
                    <input type="text" 
                           name="license_plate" 
                           id="license_plate" 
                           value="{{ old('license_plate', $member->license_plate) }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                           required>
                </div>

                 <!-- Status -->
                <div>
                    <label for="status_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Status
                    </label>
                    <select name="status_id" id="status_id"
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
                            focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Status --</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ old('status_id', $member->status_id) == $status->id ? 'selected' : '' }}>
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>
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
