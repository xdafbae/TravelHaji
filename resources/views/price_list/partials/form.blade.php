@props(['item' => null])

@php
    // Determine if we are in edit mode
    $isEdit = !is_null($item);
    
    // Default values
    $namaItem = old('nama_item', $item->nama_item ?? '');
    $harga = old('harga', $item->harga ?? '');
    $kodeItem = old('kode_item', $item->kode_item ?? '');
    $keterangan = old('keterangan', $item->keterangan ?? '');
    
    // Dates
    $tglMulai = old('tanggal_mulai', $item && $item->tanggal_mulai ? $item->tanggal_mulai->format('Y-m-d') : date('Y-m-d'));
    $tglBerakhir = old('tanggal_berakhir', $item && $item->tanggal_berakhir ? $item->tanggal_berakhir->format('Y-m-d') : '');

    // Checkboxes
    $formA = old('form_a', $item->form_a ?? false);
    $formB = old('form_b', $item->form_b ?? false);
    $formC = old('form_c', $item->form_c ?? false);
    $formD = old('form_d', $item->form_d ?? false);
    $formDBarang = old('form_d_barang', $item->form_d_barang ?? false);
    $formDJasa = old('form_d_jasa', $item->form_d_jasa ?? false);
    $isActive = old('is_active', $item->is_active ?? true);
@endphp

<div x-data="{
    submitting: false,
    price: '{{ $harga }}',
    displayPrice: '{{ $harga ? number_format($harga, 0, ',', '.') : '' }}',
    code: '{{ $kodeItem }}',
    startDate: '{{ $tglMulai }}',
    endDate: '{{ $tglBerakhir }}',
    keterangan: '{{ $keterangan }}', // Initialize with blade value
    keteranganCount: {{ strlen($keterangan) }},
    
    init() {
        this.keteranganCount = this.keterangan.length;
        // Ensure textarea matches content
        this.$watch('keterangan', value => {
            this.keteranganCount = value.length;
        });
    },

    updatePrice(e) {
        let val = e.target.value.replace(/\D/g, '');
        this.price = val;
        this.displayPrice = val ? new Intl.NumberFormat('id-ID').format(val) : '';
    },
    
    validateDates() {
        return !this.startDate || !this.endDate || this.endDate >= this.startDate;
    },

    // Checkbox states
    formA: {{ $formA ? 'true' : 'false' }},
    formB: {{ $formB ? 'true' : 'false' }},
    formC: {{ $formC ? 'true' : 'false' }},
    formD: {{ $formD ? 'true' : 'false' }},
    formDBarang: {{ $formDBarang ? 'true' : 'false' }},
    formDJasa: {{ $formDJasa ? 'true' : 'false' }}
}" @submit="submitting = true">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Main Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card 1: Informasi Dasar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center">
                    <div class="bg-emerald-100 text-emerald-600 rounded-lg p-2 mr-3">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">Informasi Dasar</h3>
                </div>
                
                <div class="p-6 space-y-5">
                    <!-- Nama Item -->
                    <div>
                        <x-input-label for="nama_item" :value="__('Nama Item')" class="text-gray-700 font-semibold mb-1" />
                        <x-text-input id="nama_item" class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors" 
                            type="text" name="nama_item" value="{{ $namaItem }}" required autofocus placeholder="Contoh: Paket Umroh VIP" />
                        <x-input-error :messages="$errors->get('nama_item')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Harga -->
                        <div>
                            <x-input-label for="display_harga" :value="__('Harga')" class="text-gray-700 font-semibold mb-1" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-medium">Rp</span>
                                </div>
                                <x-text-input id="display_harga" x-model="displayPrice" @input="updatePrice" 
                                    class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm font-mono text-lg" 
                                    type="text" placeholder="0" />
                                <input type="hidden" name="harga" x-model="price">
                            </div>
                            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                        </div>

                        <!-- Kode Item -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <x-input-label for="kode_item" :value="__('Kode Item')" class="text-gray-700 font-semibold" />
                                <span class="text-xs text-gray-400 italic" x-show="!code">Auto-generated</span>
                            </div>
                            <div class="relative">
                                <x-text-input id="kode_item" x-model="code" 
                                    class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm uppercase tracking-wider" 
                                    type="text" name="kode_item" placeholder="Kosongkan untuk auto-generate" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" x-show="!code">
                                    <i class="fas fa-magic text-emerald-400 animate-pulse"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('kode_item')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Periode & Keterangan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                 <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center">
                    <div class="bg-blue-100 text-blue-600 rounded-lg p-2 mr-3">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">Periode & Detail</h3>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Tanggal Mulai -->
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Mulai Berlaku')" class="text-gray-700 font-semibold mb-1" />
                            <x-text-input id="tanggal_mulai" x-model="startDate" 
                                class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" 
                                type="date" name="tanggal_mulai" />
                            <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div>
                            <x-input-label for="tanggal_berakhir" :value="__('Berakhir (Opsional)')" class="text-gray-700 font-semibold mb-1" />
                            <x-text-input id="tanggal_berakhir" x-model="endDate" x-bind:min="startDate" 
                                class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" 
                                x-bind:class="{'border-red-300 focus:border-red-500 focus:ring-red-500': !validateDates()}"
                                type="date" name="tanggal_berakhir" />
                            
                            <!-- Error Message for Date Logic -->
                            <div x-show="!validateDates()" x-transition class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>
                                <span>Tanggal berakhir tidak boleh sebelum tanggal mulai.</span>
                            </div>
                            <x-input-error :messages="$errors->get('tanggal_berakhir')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <x-input-label for="keterangan" :value="__('Keterangan')" class="text-gray-700 font-semibold" />
                            <span class="text-xs font-medium" :class="keteranganCount > 200 ? 'text-orange-500' : 'text-gray-400'" x-text="keteranganCount + '/255'"></span>
                        </div>
                        <textarea id="keterangan" name="keterangan" x-model="keterangan" maxlength="255" 
                            class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors" 
                            rows="3" placeholder="Deskripsi tambahan mengenai item ini..."></textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings -->
        <div class="space-y-6">
            
            <!-- Card 3: Klasifikasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center">
                    <div class="bg-purple-100 text-purple-600 rounded-lg p-2 mr-3">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">Klasifikasi</h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Tipe Form -->
                        <div>
                            <h4 class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-3">Tipe Form</h4>
                            <div class="grid grid-cols-1 gap-2">
                                <label class="relative flex items-center p-3 rounded-lg border cursor-pointer transition-all duration-200 hover:bg-gray-50" 
                                    :class="formA ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200'">
                                    <input type="checkbox" name="form_a" value="1" x-model="formA" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <span class="ml-3 flex-1">
                                        <span class="block text-sm font-medium text-gray-900">Form A</span>
                                        <span class="block text-xs text-gray-500">Paket Perjalanan</span>
                                    </span>
                                </label>
                                
                                <label class="relative flex items-center p-3 rounded-lg border cursor-pointer transition-all duration-200 hover:bg-gray-50"
                                    :class="formB ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200'">
                                    <input type="checkbox" name="form_b" value="1" x-model="formB" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <span class="ml-3 flex-1">
                                        <span class="block text-sm font-medium text-gray-900">Form B</span>
                                        <span class="block text-xs text-gray-500">Perlengkapan</span>
                                    </span>
                                </label>
                                
                                <label class="relative flex items-center p-3 rounded-lg border cursor-pointer transition-all duration-200 hover:bg-gray-50"
                                    :class="formC ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200'">
                                    <input type="checkbox" name="form_c" value="1" x-model="formC" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <span class="ml-3 flex-1">
                                        <span class="block text-sm font-medium text-gray-900">Form C</span>
                                        <span class="block text-xs text-gray-500">Dokumen</span>
                                    </span>
                                </label>

                                <label class="relative flex items-center p-3 rounded-lg border cursor-pointer transition-all duration-200 hover:bg-gray-50"
                                    :class="formD ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200'">
                                    <input type="checkbox" name="form_d" value="1" x-model="formD" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <span class="ml-3 flex-1">
                                        <span class="block text-sm font-medium text-gray-900">Form D</span>
                                        <span class="block text-xs text-gray-500">Lain-lain</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Jenis Item -->
                        <div>
                            <h4 class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-3">Jenis Item</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex flex-col items-center justify-center p-3 rounded-lg border cursor-pointer hover:bg-gray-50 text-center"
                                     :class="formDBarang ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-gray-200 text-gray-600'">
                                    <input type="checkbox" name="form_d_barang" value="1" x-model="formDBarang" class="sr-only">
                                    <i class="fas fa-box mb-1 text-lg"></i>
                                    <span class="text-xs font-medium">Barang</span>
                                </label>
                                
                                <label class="flex flex-col items-center justify-center p-3 rounded-lg border cursor-pointer hover:bg-gray-50 text-center"
                                     :class="formDJasa ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-gray-200 text-gray-600'">
                                    <input type="checkbox" name="form_d_jasa" value="1" x-model="formDJasa" class="sr-only">
                                    <i class="fas fa-hands-helping mb-1 text-lg"></i>
                                    <span class="text-xs font-medium">Jasa</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Status (Only for Edit or default Active for Create) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Status Item</h3>
                            <p class="text-xs text-gray-500">Aktifkan atau nonaktifkan item ini.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $isActive ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Action Buttons (Sticky Bottom on Mobile) -->
    <div class="mt-8 flex items-center justify-end space-x-4 pt-5 border-t border-gray-200">
        <a href="{{ route('price-list.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
            {{ __('Batal') }}
        </a>
        
        <x-primary-button class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 rounded-lg shadow-md transition-all transform active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed" ::disabled="submitting || !validateDates()">
            <span x-show="!submitting" class="flex items-center">
                <i class="fas fa-save mr-2"></i>
                {{ $isEdit ? __('Perbarui Item') : __('Simpan Item') }}
            </span>
            <span x-show="submitting" class="flex items-center" style="display: none;">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        </x-primary-button>
    </div>

</div>
