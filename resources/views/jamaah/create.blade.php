<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Jamaah Baru') }}
            </h2>
            <a href="{{ route('jamaah.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div x-data="jamaahForm()" class="bg-white rounded-xl shadow-lg overflow-hidden relative">
        
        <!-- Progress Bar (Top) -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gray-100">
            <div class="h-full bg-emerald-500 transition-all duration-500 ease-out" 
                 :style="'width: ' + ((step / 5) * 100) + '%'"></div>
        </div>

        <div class="p-8">
            <!-- Stepper Navigation -->
            <div class="flex flex-wrap items-center justify-center mb-10 gap-2 md:gap-0">
                <template x-for="(label, index) in steps" :key="index">
                    <div class="flex items-center">
                        <div class="flex flex-col items-center cursor-pointer group" @click="if(step > index + 1) step = index + 1">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300 border-2"
                                 :class="step > index + 1 ? 'bg-emerald-500 border-emerald-500 text-white' : (step === index + 1 ? 'bg-white border-emerald-500 text-emerald-600 shadow-md scale-110' : 'bg-white border-gray-200 text-gray-400 group-hover:border-gray-300')">
                                <span x-text="step > index + 1 ? '&#10003;' : index + 1"></span>
                            </div>
                            <span class="mt-2 text-xs font-medium uppercase tracking-wider transition-colors duration-300 hidden md:block"
                                  :class="step >= index + 1 ? 'text-emerald-600' : 'text-gray-400'" x-text="label"></span>
                        </div>
                        <div class="w-10 md:w-20 h-1 mx-2 md:mx-4 bg-gray-100 rounded-full" x-show="index < steps.length - 1">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                                 :style="'width: ' + (step > index + 1 ? '100%' : '0%')"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Ada data yang belum sesuai</p>
                            <ul class="list-disc ml-5 text-sm mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('jamaah.store') }}" enctype="multipart/form-data" id="jamaahForm" @submit="submitForm()">
                @csrf

                <!-- Step 1: Data Pribadi -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Informasi Pribadi</h3>
                        <p class="text-gray-500 mt-1">Isi data diri jamaah sesuai dengan KTP</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        <!-- Nama Lengkap -->
                        <div class="relative">
                            <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="nama_lengkap" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="text" name="nama_lengkap" x-model="formData.nama_lengkap" @input="formatNama()" placeholder="Contoh: Ahmad Fulan" required />
                            </div>
                        </div>

                        <!-- NIK -->
                        <div class="relative">
                            <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                </div>
                                <input id="nik" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="text" name="nik" x-model="formData.nik" @input="formatNik()" maxlength="16" placeholder="16 digit angka" required />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="formData.nik.length === 16">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                            <div class="mt-1 flex gap-4">
                                <label class="flex-1 relative cursor-pointer group">
                                    <input type="radio" name="jenis_kelamin" value="L" x-model="formData.jenis_kelamin" class="peer sr-only">
                                    <div class="p-3 text-center rounded-lg border border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all hover:bg-gray-50">
                                        <i class="fas fa-male text-xl mb-1 block"></i>
                                        <span class="text-sm font-medium">Laki-laki</span>
                                    </div>
                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check-circle text-emerald-500"></i>
                                    </div>
                                </label>
                                <label class="flex-1 relative cursor-pointer group">
                                    <input type="radio" name="jenis_kelamin" value="P" x-model="formData.jenis_kelamin" class="peer sr-only">
                                    <div class="p-3 text-center rounded-lg border border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all hover:bg-gray-50">
                                        <i class="fas fa-female text-xl mb-1 block"></i>
                                        <span class="text-sm font-medium">Perempuan</span>
                                    </div>
                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check-circle text-emerald-500"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Tgl Lahir -->
                        <div>
                            <x-input-label for="tgl_lahir" value="Tanggal Lahir" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input id="tgl_lahir" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="date" name="tgl_lahir" x-model="formData.tgl_lahir" />
                            </div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <input id="tempat_lahir" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="text" name="tempat_lahir" x-model="formData.tempat_lahir" placeholder="Kota Kelahiran" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Kontak & Alamat -->
                <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Kontak & Alamat</h3>
                        <p class="text-gray-500 mt-1">Informasi domisili dan kontak yang bisa dihubungi</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <x-input-label for="alamat" value="Alamat Lengkap" />
                            <div class="relative mt-1">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-home text-gray-400"></i>
                                </div>
                                <textarea id="alamat" name="alamat" rows="3" x-model="formData.alamat"
                                    class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200"
                                    placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                            </div>
                        </div>

                        <!-- Kabupaten -->
                        <div>
                            <x-input-label for="kabupaten" value="Kabupaten/Kota" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-city text-gray-400"></i>
                                </div>
                                <input id="kabupaten" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="text" name="kabupaten" x-model="formData.kabupaten" />
                            </div>
                        </div>

                        <!-- No HP -->
                        <div>
                            <x-input-label for="no_hp" value="Nomor HP / WhatsApp" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input id="no_hp" class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" 
                                       type="text" name="no_hp" x-model="formData.no_hp" placeholder="08xxxxxxxxxx" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Dokumen -->
                <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Upload Dokumen</h3>
                        <p class="text-gray-500 mt-1">Unggah dokumen persyaratan (Format: JPG/PNG, Max: 10MB)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                        <!-- File Upload Components -->
                        @foreach(['foto_ktp' => 'Foto KTP', 'foto_kk' => 'Foto KK', 'foto_diri' => 'Foto Diri (Formal)'] as $key => $label)
                            <div class="bg-white p-4 rounded-xl border-2 border-dashed transition-all duration-300 relative group"
                                 :class="dragOver === '{{ $key }}' ? 'border-emerald-500 bg-emerald-50' : 'border-gray-300 hover:border-emerald-400'"
                                 @dragover.prevent="dragOver = '{{ $key }}'"
                                 @dragleave.prevent="dragOver = null"
                                 @drop.prevent="dragOver = null; handleDrop($event, '{{ $key }}')">
                                
                                <x-input-label for="{{ $key }}" value="{{ $label }}" class="mb-2 text-center block font-semibold" />
                                
                                <div class="flex flex-col items-center justify-center h-48 cursor-pointer relative"
                                     @click="document.getElementById('{{ $key }}').click()">
                                    
                                    <!-- Preview -->
                                    <div x-show="previews['{{ $key }}']" class="absolute inset-0 w-full h-full rounded-lg overflow-hidden bg-gray-100" style="display: none;">
                                        <img :src="previews['{{ $key }}']" class="w-full h-full object-contain">
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-white font-medium"><i class="fas fa-edit mr-2"></i>Ganti File</span>
                                        </div>
                                    </div>

                                    <!-- Placeholder -->
                                    <div x-show="!previews['{{ $key }}']" class="text-center">
                                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-cloud-upload-alt text-xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">Drag & Drop file disini</p>
                                        <p class="text-xs text-gray-400 mt-1">atau klik untuk browse</p>
                                    </div>
                                </div>

                                <input type="file" name="{{ $key }}" id="{{ $key }}" class="hidden" accept="image/*"
                                       @change="handleFileUpload($event, '{{ $key }}')">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 4: Info Pembayaran -->
                <div x-show="step === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Informasi Pembayaran</h3>
                        <p class="text-gray-500 mt-1">Setup awal status pembayaran jamaah</p>
                    </div>

                    <div class="max-w-3xl mx-auto">
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-info text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900">Informasi Pembayaran</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Status pembayaran akan otomatis diperbarui ketika Anda mencatat transaksi pemasukan untuk jamaah ini di menu <strong>Keuangan > Buku Kas & Transaksi</strong>.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label value="Status Pembayaran Awal" class="mb-2" />
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center justify-between opacity-75">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                                        <span class="font-semibold text-gray-700">Belum Lunas</span>
                                    </div>
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="hidden" name="status_pembayaran_awal" value="Belum Lunas">
                            </div>

                            <div>
                                <x-input-label for="bank_pembayaran" value="Bank Pembayaran" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-university text-gray-400"></i>
                                    </div>
                                    <select name="bank_pembayaran" id="bank_pembayaran" x-model="formData.bank_pembayaran" 
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200">
                                        <option value="">-- Pilih Bank --</option>
                                        <option value="BSI">BSI (Bank Syariah Indonesia)</option>
                                        <option value="Mandiri">Bank Mandiri</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BNI">BNI</option>
                                        <option value="Muamalat">Bank Muamalat</option>
                                        <option value="CIMB Niaga Syariah">CIMB Niaga Syariah</option>
                                        <option value="Mega Syariah">Bank Mega Syariah</option>
                                        <option value="Lainnya">Lainnya / Tunai</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="nama_agen" value="Nama Agen / Syiar" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                    </div>
                                    <input type="text" name="nama_agen" id="nama_agen" x-model="formData.nama_agen" 
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200"
                                        placeholder="Nama Agen atau Syiar">
                                </div>
                            </div>
                            
                            <div>
                                <x-input-label for="catatan_pembayaran" value="Catatan Tambahan (Opsional)" />
                                <div class="relative mt-1">
                                    <textarea name="catatan_pembayaran" id="catatan_pembayaran" x-model="formData.catatan_pembayaran"
                                        class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition duration-200" rows="3" 
                                        placeholder="Contoh: Sudah DP 5 Juta via Transfer"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Review & Simpan -->
                <div x-show="step === 5" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Review Data</h3>
                        <p class="text-gray-500 mt-1">Pastikan semua data sudah benar sebelum disimpan</p>
                    </div>

                    <div class="max-w-4xl mx-auto bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Personal Info Review -->
                            <div>
                                <h4 class="font-bold text-emerald-700 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                    <i class="fas fa-user-circle mr-2"></i> Data Pribadi
                                </h4>
                                <dl class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Nama Lengkap</dt>
                                        <dd class="font-medium text-gray-900" x-text="formData.nama_lengkap || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">NIK</dt>
                                        <dd class="font-medium text-gray-900" x-text="formData.nik || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Jenis Kelamin</dt>
                                        <dd class="font-medium text-gray-900" x-text="formData.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">TTL</dt>
                                        <dd class="font-medium text-gray-900"><span x-text="formData.tempat_lahir || '-'"></span>, <span x-text="formData.tgl_lahir || '-'"></span></dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Contact Review -->
                            <div>
                                <h4 class="font-bold text-emerald-700 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                    <i class="fas fa-address-book mr-2"></i> Kontak
                                </h4>
                                <dl class="space-y-3 text-sm">
                                    <div>
                                        <dt class="text-gray-500 text-xs uppercase">Alamat</dt>
                                        <dd class="font-medium text-gray-900 mt-1" x-text="formData.alamat || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Kabupaten</dt>
                                        <dd class="font-medium text-gray-900" x-text="formData.kabupaten || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">No HP</dt>
                                        <dd class="font-medium text-gray-900" x-text="formData.no_hp || '-'"></dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <!-- Documents Status -->
                            <div class="md:col-span-2">
                                <h4 class="font-bold text-emerald-700 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                    <i class="fas fa-file-alt mr-2"></i> Kelengkapan Dokumen
                                </h4>
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="flex items-center space-x-2" :class="previews.foto_ktp ? 'text-emerald-600' : 'text-gray-400'">
                                        <i class="fas" :class="previews.foto_ktp ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                        <span class="text-sm font-medium">KTP</span>
                                    </div>
                                    <div class="flex items-center space-x-2" :class="previews.foto_kk ? 'text-emerald-600' : 'text-gray-400'">
                                        <i class="fas" :class="previews.foto_kk ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                        <span class="text-sm font-medium">KK</span>
                                    </div>
                                    <div class="flex items-center space-x-2" :class="previews.foto_diri ? 'text-emerald-600' : 'text-gray-400'">
                                        <i class="fas" :class="previews.foto_diri ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                        <span class="text-sm font-medium">Foto Diri</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment & Agent Review -->
                            <div class="md:col-span-2">
                                <h4 class="font-bold text-emerald-700 mb-4 border-b border-gray-200 pb-2 flex items-center">
                                    <i class="fas fa-wallet mr-2"></i> Info Pembayaran & Agen
                                </h4>
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 text-sm">
                                    <div class="flex justify-between md:block">
                                        <dt class="text-gray-500 text-xs uppercase">Bank Pembayaran</dt>
                                        <dd class="font-medium text-gray-900 mt-1" x-text="formData.bank_pembayaran || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between md:block">
                                        <dt class="text-gray-500 text-xs uppercase">Nama Agen / Syiar</dt>
                                        <dd class="font-medium text-gray-900 mt-1" x-text="formData.nama_agen || '-'"></dd>
                                    </div>
                                    <div class="md:col-span-2">
                                        <dt class="text-gray-500 text-xs uppercase">Catatan Pembayaran</dt>
                                        <dd class="font-medium text-gray-900 mt-1" x-text="formData.catatan_pembayaran || '-'"></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-10 pt-6 border-t border-gray-100">
                    <button type="button" @click="step--" x-show="step > 1" 
                            class="px-6 py-2.5 rounded-lg text-gray-600 font-medium hover:bg-gray-100 hover:text-gray-900 transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </button>
                    <div x-show="step === 1"></div> <!-- Spacer -->
                    
                    <button type="button" @click="validateAndNext(step)" x-show="step < 5" 
                            class="px-8 py-2.5 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center">
                        Lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                    
                    <button type="submit" x-show="step === 5" 
                            class="px-8 py-2.5 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center"
                            :class="isLoading ? 'opacity-75 cursor-wait' : ''"
                            :disabled="isLoading">
                        <i class="fas" :class="isLoading ? 'fa-spinner fa-spin mr-2' : 'fa-save mr-2'"></i> 
                        <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Data Jamaah'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function jamaahForm() {
            return {
                step: 1,
                steps: ['Data Pribadi', 'Kontak', 'Dokumen', 'Pembayaran', 'Review'],
                dragOver: null,
                isLoading: false,
                formData: {
                    nama_lengkap: '{{ old('nama_lengkap') }}',
                    nik: '{{ old('nik') }}',
                    jenis_kelamin: '{{ old('jenis_kelamin', 'L') }}',
                    tgl_lahir: '{{ old('tgl_lahir') }}',
                    tempat_lahir: '{{ old('tempat_lahir') }}',
                    alamat: '{{ old('alamat') }}',
                    kabupaten: '{{ old('kabupaten') }}',
                    no_hp: '{{ old('no_hp') }}',
                    bank_pembayaran: '{{ old('bank_pembayaran') }}',
                    nama_agen: '{{ old('nama_agen') }}',
                    catatan_pembayaran: '{{ old('catatan_pembayaran') }}'
                },
                previews: {
                    foto_ktp: null,
                    foto_kk: null,
                    foto_diri: null
                },
                init() {
                    // Auto-load draft from localStorage if exists and no old input
                    const savedDraft = localStorage.getItem('jamaah_form_draft');
                    if (savedDraft && !'{{ old('nama_lengkap') }}') {
                        const parsed = JSON.parse(savedDraft);
                        // Merge saved draft into formData, but respect current formData structure
                        this.formData = { ...this.formData, ...parsed };
                    }

                    // Auto-save to localStorage on change
                    this.$watch('formData', (value) => {
                        localStorage.setItem('jamaah_form_draft', JSON.stringify(value));
                    });
                },
                submitForm() {
                    this.isLoading = true;
                    // Clear draft on submit
                    localStorage.removeItem('jamaah_form_draft');
                    // Allow the form to submit naturally
                    return true;
                },
                formatNama() {
                    // Title Case logic
                    this.formData.nama_lengkap = this.formData.nama_lengkap.replace(/\w\S*/g, (txt) => {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                },
                formatNik() {
                    // Only numbers
                    this.formData.nik = this.formData.nik.replace(/\D/g, '').slice(0, 16);
                },
                validateAndNext(currentStep) {
                    if (currentStep === 1) {
                         if(!this.formData.nama_lengkap || !this.formData.nik) {
                             alert('Mohon lengkapi Nama dan NIK terlebih dahulu.');
                             return;
                         }
                    }
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },
                handleFileUpload(event, field) {
                    const file = event.target.files[0];
                    if (file) {
                        this.previewFile(file, field);
                    }
                },
                handleDrop(event, field) {
                    const file = event.dataTransfer.files[0];
                    if (file) {
                        const input = document.getElementById(field);
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        this.previewFile(file, field);
                    }
                },
                previewFile(file, field) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        this.previews[field] = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</x-app-layout>