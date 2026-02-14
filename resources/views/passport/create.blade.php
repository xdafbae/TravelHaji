<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Data Paspor') }}
            </h2>
            <a href="{{ route('passport.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('passport.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Kolom Kiri: Pilih Jamaah & Data Diri -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Card Pilih Jamaah -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                            <div class="p-5 border-b border-gray-100 bg-gray-50">
                                <h3 class="font-semibold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Pilih Jamaah
                                </h3>
                            </div>
                            <div class="p-5">
                                <div class="mb-4">
                                    <x-input-label for="id_jamaah" :value="__('Jamaah (Belum Punya Paspor)')" />
                                    <div class="relative mt-1">
                                        <select id="id_jamaah" name="id_jamaah" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm block w-full pl-3 pr-10 py-2.5" required>
                                            <option value="">-- Pilih Jamaah --</option>
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
                                    </div>
                                    <x-input-error :messages="$errors->get('id_jamaah')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-2 bg-blue-50 text-blue-700 p-2 rounded">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Data di formulir kanan akan terisi otomatis sesuai data jamaah yang dipilih.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Data Diri di Paspor -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                            <div class="p-5 border-b border-gray-100 bg-gray-50">
                                <h3 class="font-semibold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 2-3 2m3-2h6m-16 5f5 5 0 0010 0"></path>
                                    </svg>
                                    Identitas Personal
                                </h3>
                            </div>
                            <div class="p-5 space-y-4">
                                <div>
                                    <x-input-label for="nama_passport" :value="__('Nama Lengkap di Paspor')" />
                                    <x-text-input id="nama_passport" class="block mt-1 w-full uppercase bg-gray-50" type="text" name="nama_passport" :value="old('nama_passport')" required placeholder="SESUAI PASPOR" />
                                    <x-input-error :messages="$errors->get('nama_passport')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                        <select id="gender" name="gender" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm block mt-1 w-full bg-gray-50" required>
                                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="birth_city" :value="__('Kota Kelahiran')" />
                                        <x-text-input id="birth_city" class="block mt-1 w-full uppercase bg-gray-50" type="text" name="birth_city" :value="old('birth_city')" required />
                                        <x-input-error :messages="$errors->get('birth_city')" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="birth_date" class="block mt-1 w-full bg-gray-50" type="date" name="birth_date" :value="old('birth_date')" required />
                                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                                </div>

                                <!-- Optional Fields Toggle -->
                                <div x-data="{ open: false }" class="pt-2">
                                    <button type="button" @click="open = !open" class="text-sm text-emerald-600 hover:text-emerald-700 flex items-center font-medium">
                                        <span x-text="open ? 'Sembunyikan Nama Detail' : 'Tampilkan Nama Detail (Opsional)'"></span>
                                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" class="mt-3 space-y-4" style="display: none;">
                                        <div>
                                            <x-input-label for="first_name" :value="__('Nama Depan')" />
                                            <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name" :value="old('first_name')" placeholder="FIRST NAME" />
                                        </div>
                                        <div>
                                            <x-input-label for="last_name" :value="__('Nama Belakang')" />
                                            <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name" :value="old('last_name')" placeholder="LAST NAME" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Detail Paspor & Dokumen -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Card Detail Paspor -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                            <div class="p-5 border-b border-gray-100 bg-gray-50">
                                <h3 class="font-semibold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Detail Dokumen Paspor
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <x-input-label for="no_passport" :value="__('Nomor Paspor')" />
                                        <div class="relative mt-1">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 font-bold">#</span>
                                            </div>
                                            <x-text-input id="no_passport" class="block w-full pl-8 uppercase font-mono text-lg tracking-wide" type="text" name="no_passport" :value="old('no_passport')" required placeholder="X1234567" />
                                        </div>
                                        <x-input-error :messages="$errors->get('no_passport')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="issuing_office" :value="__('Kantor Imigrasi Penerbit')" />
                                        <x-text-input id="issuing_office" class="block mt-1 w-full uppercase" type="text" name="issuing_office" :value="old('issuing_office')" required placeholder="KANIM JAKARTA..." />
                                        <x-input-error :messages="$errors->get('issuing_office')" class="mt-2" />
                                    </div>

                                    <div class="hidden md:block"></div> <!-- Spacer -->

                                    <div>
                                        <x-input-label for="date_issued" :value="__('Tanggal Terbit')" />
                                        <x-text-input id="date_issued" class="block mt-1 w-full" type="date" name="date_issued" :value="old('date_issued')" required />
                                        <x-input-error :messages="$errors->get('date_issued')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="date_expire" :value="__('Tanggal Habis Berlaku')" />
                                        <x-text-input id="date_expire" class="block mt-1 w-full" type="date" name="date_expire" :value="old('date_expire')" required />
                                        <x-input-error :messages="$errors->get('date_expire')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Upload -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                            <div class="p-5 border-b border-gray-100 bg-gray-50">
                                <h3 class="font-semibold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload Scan Paspor
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="w-full">
                                    <x-input-label for="scan_passport" :value="__('File Scan (JPG/PDF)')" class="mb-2" />
                                    
                                    <div class="flex items-center justify-center w-full">
                                        <label for="scan_passport" class="flex flex-col items-center justify-center w-full h-32 border-2 border-emerald-300 border-dashed rounded-lg cursor-pointer bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-emerald-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-emerald-600">Klik untuk upload</span> atau drag and drop</p>
                                                <p class="text-xs text-gray-500">SVG, PNG, JPG or PDF (MAX. 10MB)</p>
                                            </div>
                                            <input id="scan_passport" type="file" name="scan_passport" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="document.getElementById('file-name').innerText = this.files[0].name" />
                                        </label>
                                    </div>
                                    <p id="file-name" class="mt-2 text-sm text-gray-600 font-medium"></p>
                                    <x-input-error :messages="$errors->get('scan_passport')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('passport.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-md transform hover:-translate-y-0.5 transition-all">
                                {{ __('Simpan Data Paspor') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Auto-fill Script & Plugins -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tom Select
            new TomSelect("#id_jamaah", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "-- Pilih Jamaah --"
            });

            // Initialize Flatpickr
            flatpickr("#birth_date", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true
            });

            flatpickr("#date_issued", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true
            });

            flatpickr("#date_expire", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true
            });

            // Input Masking (Uppercase)
            const uppercaseInputs = document.querySelectorAll('input.uppercase');
            uppercaseInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            });

            // Loading State on Submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
            });
        });

        document.getElementById('id_jamaah').addEventListener('change', function() {
            // Note: With Tom Select, the original select element is hidden but updated.
            // However, Tom Select wraps it, so we might need to listen to Tom Select's change event 
            // OR standard change event usually propagates. Let's verify.
            // Actually, for Tom Select we should use its API or check if change event bubbles.
            // Standard 'change' works with Tom Select usually if it updates the underlying select.
            
            // Wait, Tom Select hides the original select. 
            // Let's use the Tom Select instance if possible, or simple standard JS change event if TomSelect mirrors it.
            // Tom Select syncs with the original select, so this listener *should* fire if attached correctly,
            // BUT Tom Select might not trigger the native 'change' event on the hidden input in all versions.
            
            // Safer way: Get the option from the select (which Tom Select updates)
            var select = document.getElementById('id_jamaah');
            var selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                // Helper to set value and trigger event if needed
                const setValue = (id, val) => {
                    const el = document.getElementById(id);
                    if(el) {
                        el.value = val;
                        // Also update Flatpickr instance if exists
                        if(el._flatpickr) {
                            el._flatpickr.setDate(val);
                        }
                    }
                };

                setValue('nama_passport', selectedOption.getAttribute('data-nama'));
                setValue('gender', selectedOption.getAttribute('data-gender'));
                setValue('birth_date', selectedOption.getAttribute('data-tgllahir'));
                setValue('birth_city', selectedOption.getAttribute('data-tempatlahir'));
            }
        });
    </script>
</x-app-layout>