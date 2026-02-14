<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Transaksi') }} <span class="text-gray-400 text-base font-normal ml-2">#{{ str_pad($kas->id_kas, 6, '0', STR_PAD_LEFT) }}</span>
            </h2>
            <a href="{{ route('finance.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                
                <!-- Form Header -->
                <div class="bg-gray-50/50 px-8 py-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Perbarui Data Transaksi</h3>
                    <p class="mt-1 text-sm text-gray-500">Sesuaikan informasi transaksi yang telah tercatat sebelumnya.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('finance.update', $kas->id_kas) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column: Main Details -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-2 border-b border-gray-100 pb-2 mb-4">
                                    <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-lg text-xs"><i class="fas fa-info-circle"></i></span>
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Detail Utama</h4>
                                </div>

                                <!-- Jenis Transaksi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Jenis Transaksi <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="cursor-pointer relative group">
                                            <input type="radio" name="jenis" value="Debet" class="peer sr-only" {{ old('jenis', $kas->jenis) == 'Debet' ? 'checked' : '' }} onchange="toggleJamaahField()">
                                            <div class="p-4 text-center rounded-xl border-2 border-gray-200 bg-white peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all hover:border-emerald-200 hover:shadow-sm">
                                                <div class="text-gray-400 peer-checked:text-emerald-600 mb-2 transition-colors"><i class="fas fa-arrow-down text-2xl"></i></div>
                                                <span class="block text-sm font-bold text-gray-500 peer-checked:text-emerald-700 transition-colors">Pemasukan</span>
                                                <span class="text-xs text-gray-400 peer-checked:text-emerald-600/70">(Debet)</span>
                                            </div>
                                            <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity text-emerald-500">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer relative group">
                                            <input type="radio" name="jenis" value="Kredit" class="peer sr-only" {{ old('jenis', $kas->jenis) == 'Kredit' ? 'checked' : '' }} onchange="toggleJamaahField()">
                                            <div class="p-4 text-center rounded-xl border-2 border-gray-200 bg-white peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-red-200 hover:shadow-sm">
                                                <div class="text-gray-400 peer-checked:text-red-600 mb-2 transition-colors"><i class="fas fa-arrow-up text-2xl"></i></div>
                                                <span class="block text-sm font-bold text-gray-500 peer-checked:text-red-700 transition-colors">Pengeluaran</span>
                                                <span class="text-xs text-gray-400 peer-checked:text-red-600/70">(Kredit)</span>
                                            </div>
                                            <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity text-red-500">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal Transaksi')" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                        <input type="date" name="tanggal" id="tanggal" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors" value="{{ old('tanggal', $kas->tanggal->format('Y-m-d')) }}" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                                </div>

                                <!-- Nominal -->
                                <div>
                                    <x-input-label for="jumlah" :value="__('Nominal')" />
                                    <div class="relative mt-1 group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold group-focus-within:text-indigo-500 transition-colors">Rp</span>
                                        </div>
                                        <input type="text" name="jumlah_display" id="jumlah_display" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-mono text-lg font-semibold text-gray-700 transition-colors" value="{{ old('jumlah', $kas->jumlah) }}" required placeholder="0" oninput="formatRupiah(this)">
                                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah', $kas->jumlah) }}">
                                    </div>
                                    <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Right Column: Classification & Info -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-2 border-b border-gray-100 pb-2 mb-4">
                                    <span class="bg-indigo-100 text-indigo-600 p-1.5 rounded-lg text-xs"><i class="fas fa-tags"></i></span>
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Klasifikasi & Info</h4>
                                </div>

                                <!-- Kategori Akun -->
                                <div>
                                    <x-input-label for="kode_akuntansi_id" :value="__('Kategori Akun (COA)')" />
                                    <div class="relative mt-1">
                                        <select id="kode_akuntansi_id" name="kode_akuntansi_id" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm appearance-none transition-colors" required>
                                            <option value="">-- Pilih Akun --</option>
                                            @foreach($accounts as $acc)
                                                <option value="{{ $acc->id }}" {{ old('kode_akuntansi_id', $kas->kode_akuntansi_id) == $acc->id ? 'selected' : '' }}>
                                                    {{ $acc->kode }} - {{ $acc->keterangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('kode_akuntansi_id')" class="mt-2" />
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <x-input-label for="keterangan" :value="__('Judul / Keterangan Singkat')" />
                                    <input type="text" name="keterangan" id="keterangan" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors" value="{{ old('keterangan', $kas->keterangan) }}" required placeholder="Contoh: Pembayaran Listrik">
                                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                </div>

                                <!-- Link Jamaah -->
                                <div id="jamaah_container" class="transition-all duration-300 ease-in-out">
                                    <x-input-label for="id_jamaah" :value="__('Terkait Jamaah (Opsional)')" />
                                    <div class="relative mt-1">
                                        <select id="id_jamaah" name="id_jamaah" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm appearance-none transition-colors">
                                            <option value="">-- Tidak Terkait --</option>
                                            @foreach($jamaah as $j)
                                                <option value="{{ $j->id_jamaah }}" {{ old('id_jamaah', $kas->id_jamaah) == $j->id_jamaah ? 'selected' : '' }}>
                                                    {{ $j->nama_lengkap }} ({{ $j->kode_jamaah }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i> Pilih jika transaksi terkait pembayaran jamaah.</p>
                                    <x-input-error :messages="$errors->get('id_jamaah')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Full Width Section: Description & File -->
                        <div class="mt-8 space-y-6 bg-gray-50/50 p-6 rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-2 border-b border-gray-200 pb-2 mb-4">
                                <span class="bg-gray-200 text-gray-600 p-1.5 rounded-lg text-xs"><i class="fas fa-paperclip"></i></span>
                                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Tambahan & Bukti</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <x-input-label for="deskripsi" :value="__('Catatan Detail (Opsional)')" />
                                    <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors" placeholder="Tambahkan detail jika diperlukan...">{{ old('deskripsi', $kas->deskripsi) }}</textarea>
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="bukti_transaksi" :value="__('Upload Bukti Transaksi')" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-white hover:border-indigo-400 transition-colors bg-white group cursor-pointer relative">
                                        <input id="bukti_transaksi" name="bukti_transaksi" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept=".jpg,.jpeg,.png,.pdf" onchange="previewFile()">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-indigo-500 transition-colors mb-2"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <span class="relative bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Ganti file</span>
                                                </span>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500" id="file-name">
                                                Biarkan kosong jika tidak diubah
                                            </p>
                                        </div>
                                    </div>
                                    @if($kas->bukti_transaksi)
                                        <div class="mt-3 flex items-center p-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <i class="fas fa-file-alt text-indigo-500 mr-3 text-lg"></i>
                                            <div class="flex-1 truncate">
                                                <p class="text-sm font-medium text-gray-700 truncate">File saat ini tersimpan</p>
                                                <a href="{{ asset('storage/' . $kas->bukti_transaksi) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-800 hover:underline">Lihat Bukti</a>
                                            </div>
                                            <i class="fas fa-check-circle text-emerald-500"></i>
                                        </div>
                                    @endif
                                    <x-input-error :messages="$errors->get('bukti_transaksi')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                            <a href="{{ route('finance.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition duration-200 shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition duration-200 flex items-center transform hover:-translate-y-0.5">
                                <i class="fas fa-sync-alt mr-2"></i> Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleJamaahField() {
            // Optional logic
        }

        function previewFile() {
            const input = document.getElementById('bukti_transaksi');
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = 'File terpilih: ' + input.files[0].name;
                fileNameDisplay.classList.add('text-indigo-600', 'font-medium');
            } else {
                fileNameDisplay.textContent = 'Biarkan kosong jika tidak diubah';
                fileNameDisplay.classList.remove('text-indigo-600', 'font-medium');
            }
        }

        function formatRupiah(input) {
            // Hapus karakter selain angka
            let value = input.value.replace(/\D/g, '');
            
            // Update hidden input (nilai asli untuk dikirim ke server)
            document.getElementById('jumlah').value = value;
            
            // Format tampilan dengan titik ribuan
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }

        // Initialize format on load if value exists
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.getElementById('jumlah_display');
            if (jumlahInput.value) {
                formatRupiah(jumlahInput);
            }
        });
    </script>
</x-app-layout>