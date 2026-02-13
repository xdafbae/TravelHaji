<x-app-layout>
    <x-slot name="header">
        Input Data Paspor Jamaah
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('passport.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jamaah Selection -->
                        <div class="md:col-span-2">
                            <x-input-label for="id_jamaah" :value="__('Pilih Jamaah')" />
                            <select id="id_jamaah" name="id_jamaah" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">-- Pilih Jamaah (Belum Punya Paspor) --</option>
                                @foreach($jamaah as $j)
                                    <option value="{{ $j->id_jamaah }}" {{ (old('id_jamaah') == $j->id_jamaah || $selectedJamaahId == $j->id_jamaah) ? 'selected' : '' }} 
                                        data-nama="{{ $j->nama_lengkap }}" 
                                        data-gender="{{ $j->jenis_kelamin }}"
                                        data-tgllahir="{{ $j->tgl_lahir ? $j->tgl_lahir->format('Y-m-d') : '' }}"
                                        data-tempatlahir="{{ $j->tempat_lahir }}">
                                        {{ $j->nama_lengkap }} ({{ $j->kode_jamaah }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_jamaah')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">*Hanya menampilkan jamaah yang belum memiliki data paspor.</p>
                        </div>

                        <!-- No Passport -->
                        <div>
                            <x-input-label for="no_passport" :value="__('Nomor Paspor')" />
                            <x-text-input id="no_passport" class="block mt-1 w-full uppercase" type="text" name="no_passport" :value="old('no_passport')" required placeholder="X1234567" />
                            <x-input-error :messages="$errors->get('no_passport')" class="mt-2" />
                        </div>

                        <!-- Nama di Paspor -->
                        <div>
                            <x-input-label for="nama_passport" :value="__('Nama Lengkap di Paspor')" />
                            <x-text-input id="nama_passport" class="block mt-1 w-full uppercase" type="text" name="nama_passport" :value="old('nama_passport')" required />
                            <x-input-error :messages="$errors->get('nama_passport')" class="mt-2" />
                        </div>

                        <!-- First Name / Last Name (Optional) -->
                        <div>
                            <x-input-label for="first_name" :value="__('Nama Depan (Opsional)')" />
                            <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name" :value="old('first_name')" />
                        </div>
                        <div>
                            <x-input-label for="last_name" :value="__('Nama Belakang (Opsional)')" />
                            <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name" :value="old('last_name')" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                            <select id="gender" name="gender" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <x-input-label for="birth_city" :value="__('Kota Kelahiran')" />
                            <x-text-input id="birth_city" class="block mt-1 w-full uppercase" type="text" name="birth_city" :value="old('birth_city')" required />
                            <x-input-error :messages="$errors->get('birth_city')" class="mt-2" />
                        </div>

                        <!-- Tgl Lahir -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <!-- Kantor Penerbit -->
                        <div>
                            <x-input-label for="issuing_office" :value="__('Kantor Imigrasi Penerbit')" />
                            <x-text-input id="issuing_office" class="block mt-1 w-full uppercase" type="text" name="issuing_office" :value="old('issuing_office')" required placeholder="JAKARTA SELATAN" />
                            <x-input-error :messages="$errors->get('issuing_office')" class="mt-2" />
                        </div>

                        <!-- Tgl Terbit -->
                        <div>
                            <x-input-label for="date_issued" :value="__('Tanggal Terbit')" />
                            <x-text-input id="date_issued" class="block mt-1 w-full" type="date" name="date_issued" :value="old('date_issued')" required />
                            <x-input-error :messages="$errors->get('date_issued')" class="mt-2" />
                        </div>

                        <!-- Tgl Expire -->
                        <div>
                            <x-input-label for="date_expire" :value="__('Tanggal Habis Berlaku')" />
                            <x-text-input id="date_expire" class="block mt-1 w-full" type="date" name="date_expire" :value="old('date_expire')" required />
                            <x-input-error :messages="$errors->get('date_expire')" class="mt-2" />
                        </div>

                        <!-- Scan File -->
                        <div class="md:col-span-2">
                            <x-input-label for="scan_passport" :value="__('Upload Scan Paspor (JPG/PDF)')" />
                            <input id="scan_passport" type="file" name="scan_passport" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".jpg,.jpeg,.png,.pdf">
                            <x-input-error :messages="$errors->get('scan_passport')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('passport.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Simpan Data Paspor') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Auto-fill Script -->
    <script>
        document.getElementById('id_jamaah').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById('nama_passport').value = selectedOption.getAttribute('data-nama');
                document.getElementById('gender').value = selectedOption.getAttribute('data-gender');
                document.getElementById('birth_date').value = selectedOption.getAttribute('data-tgllahir');
                document.getElementById('birth_city').value = selectedOption.getAttribute('data-tempatlahir');
            }
        });
    </script>
</x-app-layout>
