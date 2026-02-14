<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Data Paspor') }}
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
            <form action="{{ route('passport.update', $passport->id_passport) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Kolom Kiri: Info Jamaah & Data Diri -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Card Info Jamaah (Readonly) -->
                        <div class="bg-gradient-to-br from-emerald-50 to-white overflow-hidden shadow-sm rounded-xl border border-emerald-100">
                            <div class="p-5 border-b border-emerald-100/50">
                                <h3 class="font-semibold text-emerald-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Jamaah Pemilik Paspor
                                </h3>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="h-12 w-12 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700 font-bold text-lg">
                                        {{ substr($passport->jamaah->nama_lengkap, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">{{ $passport->jamaah->nama_lengkap }}</h4>
                                        <p class="text-sm text-gray-500">{{ $passport->jamaah->kode_jamaah }}</p>
                                    </div>
                                </div>
                                <input type="hidden" name="id_jamaah" value="{{ $passport->id_jamaah }}">
                                
                                <div class="text-sm text-gray-600 space-y-2 border-t border-emerald-100 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Gender:</span>
                                        <span class="font-medium">{{ $passport->jamaah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Kota Asal:</span>
                                        <span class="font-medium">{{ $passport->jamaah->tempat_lahir }}</span>
                                    </div>
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
                                    <x-text-input id="nama_passport" class="block mt-1 w-full uppercase" type="text" name="nama_passport" :value="old('nama_passport', $passport->nama_passport)" required />
                                    <x-input-error :messages="$errors->get('nama_passport')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                        <select id="gender" name="gender" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm block mt-1 w-full" required>
                                            <option value="L" {{ old('gender', $passport->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('gender', $passport->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="birth_city" :value="__('Kota Kelahiran')" />
                                        <x-text-input id="birth_city" class="block mt-1 w-full uppercase" type="text" name="birth_city" :value="old('birth_city', $passport->birth_city)" required />
                                        <x-input-error :messages="$errors->get('birth_city')" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date', $passport->birth_date ? $passport->birth_date->format('Y-m-d') : '')" required />
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
                                            <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name" :value="old('first_name', $passport->first_name)" placeholder="FIRST NAME" />
                                        </div>
                                        <div>
                                            <x-input-label for="last_name" :value="__('Nama Belakang')" />
                                            <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name" :value="old('last_name', $passport->last_name)" placeholder="LAST NAME" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Detail Paspor & Dokumen -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Card Status Visa (Only in Edit) -->
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                            <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-semibold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Status Pengajuan Visa
                                </h3>
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $passport->status_visa == 'Approved' ? 'bg-green-100 text-green-800' : 
                                      ($passport->status_visa == 'Rejected' ? 'bg-red-100 text-red-800' : 
                                      ($passport->status_visa == 'Issued' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    Current: {{ $passport->status_visa }}
                                </span>
                            </div>
                            <div class="p-6 bg-purple-50/30">
                                <div class="w-full">
                                    <x-input-label for="status_visa" :value="__('Update Status')" />
                                    <select id="status_visa" name="status_visa" class="border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm block mt-1 w-full" required>
                                        <option value="Pending" {{ old('status_visa', $passport->status_visa) == 'Pending' ? 'selected' : '' }}>Pending - Menunggu Proses</option>
                                        <option value="Approved" {{ old('status_visa', $passport->status_visa) == 'Approved' ? 'selected' : '' }}>Approved - Disetujui</option>
                                        <option value="Issued" {{ old('status_visa', $passport->status_visa) == 'Issued' ? 'selected' : '' }}>Issued - Visa Keluar</option>
                                        <option value="Rejected" {{ old('status_visa', $passport->status_visa) == 'Rejected' ? 'selected' : '' }}>Rejected - Ditolak</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status_visa')" class="mt-2" />
                                </div>
                            </div>
                        </div>

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
                                            <x-text-input id="no_passport" class="block w-full pl-8 uppercase font-mono text-lg tracking-wide" type="text" name="no_passport" :value="old('no_passport', $passport->no_passport)" required />
                                        </div>
                                        <x-input-error :messages="$errors->get('no_passport')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="issuing_office" :value="__('Kantor Imigrasi Penerbit')" />
                                        <x-text-input id="issuing_office" class="block mt-1 w-full uppercase" type="text" name="issuing_office" :value="old('issuing_office', $passport->issuing_office)" required />
                                        <x-input-error :messages="$errors->get('issuing_office')" class="mt-2" />
                                    </div>

                                    <div class="hidden md:block"></div>

                                    <div>
                                        <x-input-label for="date_issued" :value="__('Tanggal Terbit')" />
                                        <x-text-input id="date_issued" class="block mt-1 w-full" type="date" name="date_issued" :value="old('date_issued', $passport->date_issued ? $passport->date_issued->format('Y-m-d') : '')" required />
                                        <x-input-error :messages="$errors->get('date_issued')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="date_expire" :value="__('Tanggal Habis Berlaku')" />
                                        <x-text-input id="date_expire" class="block mt-1 w-full" type="date" name="date_expire" :value="old('date_expire', $passport->date_expire ? $passport->date_expire->format('Y-m-d') : '')" required />
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
                                    <x-input-label for="scan_passport" :value="__('Ganti File Scan (Biarkan kosong jika tidak diubah)')" class="mb-2" />
                                    
                                    @if($passport->scan_passport)
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg flex items-center justify-between border border-gray-200">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span class="text-sm text-gray-600">File saat ini tersimpan</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $passport->scan_passport) }}" target="_blank" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                                                Lihat File
                                            </a>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-center w-full">
                                        <label for="scan_passport" class="flex flex-col items-center justify-center w-full h-32 border-2 border-emerald-300 border-dashed rounded-lg cursor-pointer bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-emerald-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-emerald-600">Klik untuk ganti file</span> atau drag and drop</p>
                                                <p class="text-xs text-gray-500">JPG, PNG or PDF (MAX. 10MB)</p>
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
                                {{ __('Update Data Paspor') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengupdate...';
            });
        });
    </script>
</x-app-layout>