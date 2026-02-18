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
                    <span class="text-secondary-800">Tambah Data</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight leading-tight">
                    Input Data Paspor
                </h2>
            </div>
            
            <a href="{{ route('passport.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-secondary-300 rounded-xl font-bold text-sm text-secondary-700 shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <form action="{{ route('passport.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Left Column: Jamaah Selection & Basic Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Select Jamaah Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden relative group">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-400 to-primary-600"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-secondary-900 mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center mr-3 border border-primary-100">
                                <i class="fas fa-user-check"></i>
                            </span>
                            Pilih Jamaah
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="id_jamaah" class="block text-sm font-bold text-secondary-700 mb-2">Jamaah (Belum Punya Paspor)</label>
                                <select id="id_jamaah" name="id_jamaah" class="w-full rounded-xl border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="">-- Cari Nama Jamaah --</option>
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
                            </div>
                            
                            <div class="bg-primary-50 rounded-xl p-4 border border-primary-100">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-primary-500 mt-0.5 mr-2"></i>
                                    <p class="text-xs text-primary-800 font-medium leading-relaxed">
                                        Data personal seperti Nama, Gender, dan Tanggal Lahir akan terisi otomatis saat Anda memilih jamaah.
                                    </p>
                                </div>
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
                                <x-text-input id="nama_passport" class="block mt-1 w-full uppercase bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-bold" type="text" name="nama_passport" :value="old('nama_passport')" required placeholder="CONTOH: BUDI SANTOSO" />
                                <x-input-error :messages="$errors->get('nama_passport')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                    <select id="gender" name="gender" class="block mt-1 w-full rounded-xl border-secondary-200 bg-secondary-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 font-medium" required>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="birth_city" :value="__('Kota Kelahiran')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                    <x-text-input id="birth_city" class="block mt-1 w-full uppercase bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-medium" type="text" name="birth_city" :value="old('birth_city')" required />
                                    <x-input-error :messages="$errors->get('birth_city')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="birth_date" class="block w-full pl-10 bg-secondary-50 border-secondary-200 focus:bg-white transition-colors font-medium" type="text" name="birth_date" :value="old('birth_date')" required />
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
                                        <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name" :value="old('first_name')" placeholder="FIRST NAME" />
                                    </div>
                                    <div>
                                        <x-input-label for="last_name" :value="__('Nama Belakang')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                        <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name" :value="old('last_name')" placeholder="LAST NAME" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Passport Details & Upload -->
            <div class="lg:col-span-2 space-y-6">
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
                                    <x-text-input id="no_passport" class="block w-full pl-9 uppercase font-mono text-xl tracking-widest font-bold border-secondary-300 focus:border-primary-500 focus:ring-primary-500 py-3" type="text" name="no_passport" :value="old('no_passport')" required placeholder="X1234567" />
                                </div>
                                <x-input-error :messages="$errors->get('no_passport')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="issuing_office" :value="__('Kantor Imigrasi Penerbit')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="issuing_office" class="block w-full pl-10 uppercase font-medium" type="text" name="issuing_office" :value="old('issuing_office')" required placeholder="KANIM JAKARTA..." />
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
                                    <x-text-input id="date_issued" class="block w-full pl-10 font-medium" type="text" name="date_issued" :value="old('date_issued')" required />
                                </div>
                                <x-input-error :messages="$errors->get('date_issued')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_expire" :value="__('Tanggal Habis Berlaku')" class="text-xs uppercase tracking-wider text-secondary-500" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-times text-secondary-400"></i>
                                    </div>
                                    <x-text-input id="date_expire" class="block w-full pl-10 font-medium" type="text" name="date_expire" :value="old('date_expire')" required />
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
                            <div class="flex items-center justify-center w-full">
                                <label for="scan_passport" class="flex flex-col items-center justify-center w-full h-48 border-2 border-primary-200 border-dashed rounded-2xl cursor-pointer bg-primary-50/30 hover:bg-primary-50 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-file-import text-3xl text-primary-500"></i>
                                        </div>
                                        <p class="mb-2 text-sm text-secondary-600"><span class="font-bold text-primary-600">Klik untuk upload</span> atau drag and drop</p>
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
                        <i class="fas fa-save mr-2"></i> Simpan Data Paspor
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tom Select
            new TomSelect("#id_jamaah", {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "-- Cari Nama Jamaah --",
                plugins: ['dropdown_input'],
                render: {
                    option: function(data, escape) {
                        return '<div class="flex flex-col py-1 px-2">' +
                                '<span class="font-bold text-gray-800">' + escape(data.text.split('(')[0]) + '</span>' +
                                '<span class="text-xs text-gray-500">' + escape(data.text.split('(')[1] ? '(' + data.text.split('(')[1] : '') + '</span>' +
                            '</div>';
                    }
                }
            });

            // Datepickers
            const dateConfig = {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true,
                locale: "id" // Assuming ID locale is loaded, otherwise defaults to EN
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
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Menyimpan...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            });
        });

        // Auto-fill logic
        document.getElementById('id_jamaah').addEventListener('change', function() {
            var select = document.getElementById('id_jamaah');
            // Note: TomSelect hides the original select, but updates its value. 
            // We need to access the selected option from the hidden select which TomSelect updates.
            // However, the standard 'change' event might not fire on the hidden select depending on TomSelect version.
            // If the listener above doesn't trigger, we might need to hook into TomSelect's onChange.
            
            // Accessing the selected option attributes directly might be tricky if TomSelect reconstructs DOM.
            // Alternative: Find the option in the original select by value.
            
            const val = this.value;
            if(!val) return;

            const option = Array.from(this.options).find(opt => opt.value === val);
            
            if (option) {
                const setValue = (id, val) => {
                    const el = document.getElementById(id);
                    if(el) {
                        el.value = val;
                        if(el._flatpickr) el._flatpickr.setDate(val);
                    }
                };

                setValue('nama_passport', option.getAttribute('data-nama'));
                setValue('gender', option.getAttribute('data-gender'));
                setValue('birth_date', option.getAttribute('data-tgllahir'));
                setValue('birth_city', option.getAttribute('data-tempatlahir'));
            }
        });
    </script>
</x-app-layout>