<x-app-layout>
    <x-slot name="header">
        Edit Transaksi: TRX-{{ str_pad($kas->id_kas, 6, '0', STR_PAD_LEFT) }}
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('finance.update', $kas->id_kas) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Transaksi -->
                        <div>
                            <x-input-label for="jenis" :value="__('Jenis Transaksi')" />
                            <select id="jenis" name="jenis" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="Debet" {{ old('jenis', $kas->jenis) == 'Debet' ? 'selected' : '' }}>Pemasukan (Debet)</option>
                                <option value="Kredit" {{ old('jenis', $kas->jenis) == 'Kredit' ? 'selected' : '' }}>Pengeluaran (Kredit)</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Transaksi')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', $kas->tanggal->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Kategori Akun -->
                        <div>
                            <x-input-label for="kode_akuntansi_id" :value="__('Kategori Akun (COA)')" />
                            <select id="kode_akuntansi_id" name="kode_akuntansi_id" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">-- Pilih Akun --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}" {{ old('kode_akuntansi_id', $kas->kode_akuntansi_id) == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->kode }} - {{ $acc->keterangan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kode_akuntansi_id')" class="mt-2" />
                        </div>

                        <!-- Nominal -->
                        <div>
                            <x-input-label for="jumlah" :value="__('Nominal (Rp)')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', $kas->jumlah)" required min="1" />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Judul / Keterangan Singkat')" />
                            <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="old('keterangan', $kas->keterangan)" required />
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Link Jamaah (Optional) -->
                        <div class="md:col-span-2">
                            <x-input-label for="id_jamaah" :value="__('Terkait Jamaah (Opsional)')" />
                            <select id="id_jamaah" name="id_jamaah" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Tidak Terkait Jamaah --</option>
                                @foreach($jamaah as $j)
                                    <option value="{{ $j->id_jamaah }}" {{ old('id_jamaah', $kas->id_jamaah) == $j->id_jamaah ? 'selected' : '' }}>
                                        {{ $j->nama_lengkap }} ({{ $j->kode_jamaah }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_jamaah')" class="mt-2" />
                        </div>

                        <!-- Deskripsi Detail -->
                        <div class="md:col-span-2">
                            <x-input-label for="deskripsi" :value="__('Catatan Detail (Opsional)')" />
                            <textarea id="deskripsi" name="deskripsi" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('deskripsi', $kas->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <!-- Bukti Transaksi -->
                        <div class="md:col-span-2">
                            <x-input-label for="bukti_transaksi" :value="__('Upload Bukti Transaksi (Biarkan kosong jika tidak diubah)')" />
                            <input id="bukti_transaksi" type="file" name="bukti_transaksi" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".jpg,.jpeg,.png,.pdf">
                            @if($kas->bukti_transaksi)
                                <p class="text-sm text-gray-600 mt-2">File saat ini: <a href="{{ asset('storage/' . $kas->bukti_transaksi) }}" target="_blank" class="text-emerald-600 hover:underline">Lihat Bukti</a></p>
                            @endif
                            <x-input-error :messages="$errors->get('bukti_transaksi')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('finance.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Update Transaksi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
