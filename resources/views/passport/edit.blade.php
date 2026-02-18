<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div class="space-y-1">
                <nav class="flex text-sm font-medium text-secondary-500 mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('passport.index') }}" class="hover:text-primary-600 transition-colors">Manajemen Paspor</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary-800">Edit Data</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight leading-tight">
                    Edit Data Paspor
                </h2>
            </div>
            
            <a href="{{ route('passport.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-secondary-300 rounded-xl font-bold text-sm text-secondary-700 shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <form action="{{ route('passport.update', $passport->id_passport) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @method('PUT')
            
            <!-- Left Column: Jamaah Info & Basic Identity -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Jamaah Info Card (Readonly) -->
                <div class="bg-gradient-to-br from-primary-50 to-white rounded-3xl shadow-sm border border-primary-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <i class="fas fa-user text-9xl text-primary-600"></i>
                    </div>
                    <div class="p-6 relative z-10">
                        <h3 class="text-lg font-bold text-primary-900 mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-white text-primary-600 flex items-center justify-center mr-3 border border-primary-100 shadow-sm">
                                <i class="fas fa-user"></i>
                            </span>
                            Jamaah Pemilik Paspor
                        </h3>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-white text-primary-600 flex items-center justify-center text-xl font-bold shadow-sm border border-primary-100">
                                {{ substr($passport->jamaah->nama_lengkap, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary-900 text-lg">{{ $passport->jamaah->nama_lengkap }}</h4>
                                <p class="text-sm font-medium text-secondary-500 font-mono">{{ $passport->jamaah->kode_jamaah }}</p>
                            </div>
                        </div>
                        <input type="hidden" name="id_jamaah" value="{{ $passport->id_jamaah }}">
                        
                        <div class="space-y-3 pt-4 border-t border-primary-100">
                            <div class="flex justify-between text-sm">
                                <span class="text-secondary-500 font-medium">Jenis Kelamin</span>
                                <span class="font-bold text-secondary-800">{{ $passport->jamaah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-secondary-500 font-medium">Kota Asal</span>
                                <span class="font-bold text-secondary-800">{{ $passport->jamaah->tempat_lahir }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Identity Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-secondary-50 text-secondary-600 flex items-center justify-center mr-3 border border-secondary-100">
                                <i class="fas fa-id-card"></i>
                            </span>
                            Identitas Personal
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nama_passport" :value="__('Nama Lengkap (Sesuai Paspor)')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <x-text-input id="nama_passport" class="block mt-1 w-full uppercase bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-bold" type="text" name="nama_passport" :value="old('nama_passport', $passport->nama_passport)" required />
                                <x-input-error :messages="$errors->get('nama_passport')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                    <select id="gender" name="gender" class="block mt-1 w-full rounded-xl border-secondary-200 bg-secondary-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 font-medium" required>
                                        <option value="L" {{ old('gender', $passport->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $passport->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="birth_city" :value="__('Kota Kelahiran')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                    <x-text-input id="birth_city" class="block mt-1 w-full uppercase bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-medium" type="text" name="birth_city" :value="old('birth_city', $passport->birth_city)" required />
                                    <x-input-error :messages="$errors->get('birth_city')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="birth_date" class="block w-full pl-10 bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-medium" type="text" name="birth_date" :value="old('birth_date', $passport->birth_date ? $passport->birth_date->format('Y-m-d') : '')" required />
                                </div>
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Optional Fields Toggle -->
                            <div x-data="{ open: false }" class="pt-2 border-t border-secondary-100 mt-2">
                                <button type="button" @click="open = !open" class="text-xs font-bold text-primary-600 hover:text-primary-700 flex items-center w-full justify-between py-2">
                                    <span x-text="open ? 'Sembunyikan Nama Detail' : 'Tampilkan Nama Detail (Opsional)'"></span>
                                    <i class="fas fa-chevron-down transform transition-transform duration-200" :class="{'rotate-180': open}"></i>
                                </button>
                                <div x-show="open" class="mt-2 space-y-4" style="display: none;">
                                    <div>
                                        <x-input-label for="first_name" :value="__('Nama Depan')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                        <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name" :value="old('first_name', $passport->first_name)" placeholder="FIRST NAME" />
                                    </div>
                                    <div>
                                        <x-input-label for="last_name" :value="__('Nama Belakang')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                        <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name" :value="old('last_name', $passport->last_name)" placeholder="LAST NAME" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visa Status, Passport Details & Upload -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Visa Status Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <h3 class="text-lg font-bold text-secondary-900 flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3 border border-purple-100">
                                    <i class="fas fa-stamp"></i>
                                </span>
                                Status Pengajuan Visa
                            </h3>
                            @php
                                $statusConfig = match($passport->status_visa) {
                                    'Approved' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'border' => 'border-success-200', 'icon' => 'fa-check-circle'],
                                    'Issued' => ['bg' => 'bg-info-50', 'text' => 'text-info-700', 'border' => 'border-info-200', 'icon' => 'fa-stamp'],
                                    'Rejected' => ['bg' => 'bg-danger-50', 'text' => 'text-danger-700', 'border' => 'border-danger-200', 'icon' => 'fa-times-circle'],
                                    default => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'border' => 'border-warning-200', 'icon' => 'fa-clock'],
                                };
                            @endphp
                            <div class="flex items-center px-3 py-1.5 rounded-xl border {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }}">
                                <span class="text-xs font-bold text-secondary-500 mr-2 uppercase tracking-wide">Current:</span>
                                <span class="text-sm font-bold {{ $statusConfig['text'] }} flex items-center">
                                    <i class="fas {{ $statusConfig['icon'] }} mr-1.5"></i> {{ $passport->status_visa }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50/50 rounded-2xl p-5 border border-purple-100">
                            <label for="status_visa" class="block text-sm font-bold text-purple-900 mb-2">Update Status Visa</label>
                            <div class="relative">
                                <select id="status_visa" name="status_visa" class="w-full rounded-xl border-purple-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 pl-4 pr-10 font-medium text-secondary-800">
                                    <option value="Pending" {{ old('status_visa', $passport->status_visa) == 'Pending' ? 'selected' : '' }}>Pending - Menunggu Proses</option>
                                    <option value="Approved" {{ old('status_visa', $passport->status_visa) == 'Approved' ? 'selected' : '' }}>Approved - Disetujui</option>
                                    <option value="Issued" {{ old('status_visa', $passport->status_visa) == 'Issued' ? 'selected' : '' }}>Issued - Visa Keluar</option>
                                    <option value="Rejected" {{ old('status_visa', $passport->status_visa) == 'Rejected' ? 'selected' : '' }}>Rejected - Ditolak</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('status_visa')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Passport Data Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-secondary-50 text-secondary-600 flex items-center justify-center mr-3 border border-secondary-100">
                                <i class="fas fa-passport"></i>
                            </span>
                            Detail Dokumen Paspor
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="no_passport" :value="__('Nomor Paspor')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-secondary-400 font-bold">#</span>
                                    </div>
                                    <x-text-input id="no_passport" class="block w-full pl-9 uppercase font-mono text-xl tracking-widest font-bold border-secondary-300 focus:border-primary-500 focus:ring-primary-500 py-3" type="text" name="no_passport" :value="old('no_passport', $passport->no_passport)" required />
                                </div>
                                <x-input-error :messages="$errors->get('no_passport')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="issuing_office" :value="__('Kantor Imigrasi Penerbit')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="issuing_office" class="block w-full pl-10 uppercase font-medium" type="text" name="issuing_office" :value="old('issuing_office', $passport->issuing_office)" required />
                                </div>
                                <x-input-error :messages="$errors->get('issuing_office')" class="mt-2" />
                            </div>

                            <div class="hidden md:block"></div> <!-- Spacer -->

                            <div>
                                <x-input-label for="date_issued" :value="__('Tanggal Terbit')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="date_issued" class="block w-full pl-10 font-medium" type="text" name="date_issued" :value="old('date_issued', $passport->date_issued ? $passport->date_issued->format('Y-m-d') : '')" required />
                                </div>
                                <x-input-error :messages="$errors->get('date_issued')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_expire" :value="__('Tanggal Habis Berlaku')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-times text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="date_expire" class="block w-full pl-10 font-medium" type="text" name="date_expire" :value="old('date_expire', $passport->date_expire ? $passport->date_expire->format('Y-m-d') : '')" required />
                                </div>
                                <x-input-error :messages="$errors->get('date_expire')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-secondary-50 text-secondary-600 flex items-center justify-center mr-3 border border-secondary-100">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </span>
                            Upload Scan Paspor
                        </h3>
                        
                        <div class="w-full">
                            @if($passport->scan_passport)
                                <div class="mb-6 p-4 bg-success-50 rounded-2xl flex items-center justify-between border border-success-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-white text-success-500 flex items-center justify-center mr-3 shadow-sm">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-success-800">File Tersimpan</p>
                                            <p class="text-xs text-success-600">Dokumen scan paspor aman.</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $passport->scan_passport) }}" target="_blank" class="px-4 py-2 bg-white text-success-700 text-xs font-bold rounded-lg border border-success-200 hover:bg-success-50 transition-colors shadow-sm">
                                        Lihat File
                                    </a>
                                </div>
                            @endif

                            <x-input-label for="scan_passport" :value="__('Ganti File Scan (Biarkan kosong jika tidak diubah)')" class="mb-2 text-xs uppercase tracking-wider text-secondary-500" />
                            <div class="flex items-center justify-center w-full">
                                <label for="scan_passport" class="flex flex-col items-center justify-center w-full h-48 border-2 border-primary-200 border-dashed rounded-2xl cursor-pointer bg-primary-50/30 hover:bg-primary-50 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-file-import text-3xl text-primary-500"></i>
                                        </div>
                                        <p class="mb-2 text-sm text-secondary-600"><span class="font-bold text-primary-600">Klik untuk ganti file</span> atau drag and drop</p>
                                        <p class="text-xs text-secondary-500">JPG, PNG, atau PDF (Maks. 10MB)</p>
                                    </div>
                                    <input id="scan_passport" type="file" name="scan_passport" class="hidden" accept=".jpg,.jpeg,.png,.pdf" onchange="document.getElementById('file-name').innerText = this.files[0].name; document.getElementById('file-name-container').classList.remove('hidden');" />
                                </label>
                            </div>
                            <div id="file-name-container" class="mt-4 hidden animate-fade-in-up">
                                <div class="flex items-center p-3 bg-secondary-50 rounded-xl border border-secondary-200">
                                    <i class="fas fa-file text-secondary-400 mr-3"></i>
                                    <span id="file-name" class="text-sm font-bold text-secondary-700 truncate"></span>
                                    <i class="fas fa-check-circle text-success-500 ml-auto"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('scan_passport')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-secondary-100">
                    <a href="{{ route('passport.index') }}" class="px-6 py-3 text-sm font-bold text-secondary-600 bg-white border border-secondary-300 rounded-xl hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Data Paspor
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datepickers
            const dateConfig = {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true,
                locale: "id"
            };
            
            flatpickr("#birth_date", dateConfig);
            flatpickr("#date_issued", dateConfig);
            flatpickr("#date_expire", dateConfig);

            // Uppercase Input
            document.querySelectorAll('input.uppercase').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            });

            // Loading State
            document.querySelector('form').addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Mengupdate...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            });
        });
    </script>
</x-app-layout>