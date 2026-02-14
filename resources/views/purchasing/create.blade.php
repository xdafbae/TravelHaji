<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Buat Purchase Order Baru') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Isi form berikut untuk membuat pesanan pembelian baru.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <a href="{{ route('purchasing.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Purchasing</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="text-sm font-medium text-gray-500">Create</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="purchaseForm()">
        
        <!-- Error Handling -->
        @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada inputan Anda:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('purchasing.store') }}" method="POST" @submit.prevent="submitForm">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Header Info -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Informasi PO</h3>
                            
                            <div class="space-y-4">
                                <!-- Supplier -->
                                <div>
                                    <x-input-label for="id_supplier" :value="__('Supplier')" />
                                    <div class="relative">
                                        <select id="id_supplier" name="id_supplier" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full pl-10" required>
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id_supplier }}" {{ old('id_supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                                                    {{ $supplier->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-truck text-gray-400"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('id_supplier')" class="mt-2" />
                                </div>

                                <!-- Tanggal Preorder -->
                                <div>
                                    <x-input-label for="waktu_preorder" :value="__('Tanggal PO')" />
                                    <div class="relative">
                                        <x-text-input id="waktu_preorder" class="block mt-1 w-full pl-10" type="date" name="waktu_preorder" :value="old('waktu_preorder', date('Y-m-d'))" required />
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('waktu_preorder')" class="mt-2" />
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <x-input-label for="keterangan" :value="__('Keterangan / Catatan')" />
                                    <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="4" placeholder="Contoh: Pengiriman harap dilakukan sebelum jam 12 siang.">{{ old('keterangan') }}</textarea>
                                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 min-h-[400px]">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                                <button type="button" @click="addItem()" class="text-sm px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 font-medium transition-colors">
                                    <i class="fas fa-plus mr-1"></i> Tambah Baris
                                </button>
                            </div>

                            <!-- Empty State -->
                            <div x-show="items.length === 0" class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                <div class="text-gray-400 mb-2">
                                    <i class="fas fa-box-open text-4xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada barang yang ditambahkan.</p>
                                <button type="button" @click="addItem()" class="mt-3 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                                    + Tambah Barang Pertama
                                </button>
                            </div>

                            <!-- Items Table -->
                            <div x-show="items.length > 0" class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                                            <th class="py-2 px-3 w-10 text-center">#</th>
                                            <th class="py-2 px-3">Barang</th>
                                            <th class="py-2 px-3 w-24 text-right">Qty</th>
                                            <th class="py-2 px-3 w-32 text-right">Harga (@)</th>
                                            <th class="py-2 px-3 w-32 text-right">Subtotal</th>
                                            <th class="py-2 px-3 w-10 text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        <template x-for="(item, index) in items" :key="index">
                                            <tr class="border-b border-gray-100 hover:bg-gray-50 group">
                                                <td class="py-2 px-3 text-center text-gray-400" x-text="index + 1"></td>
                                                <td class="py-2 px-3">
                                                    <select :name="`items[${index}][id_stok]`" x-model="item.id_stok" class="w-full text-sm border-gray-300 rounded focus:ring-emerald-500 focus:border-emerald-500 py-1" required>
                                                        <option value="">Pilih Barang...</option>
                                                        @foreach($items as $stok)
                                                            <option value="{{ $stok->id_stok }}">{{ $stok->kode_barang }} - {{ $stok->nama_barang }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="py-2 px-3">
                                                    <input type="number" :name="`items[${index}][qty]`" x-model.number="item.qty" min="1" class="w-full text-sm border-gray-300 rounded focus:ring-emerald-500 focus:border-emerald-500 py-1 text-right" required>
                                                </td>
                                                <td class="py-2 px-3">
                                                    <div class="relative rounded-md shadow-sm">
                                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                                            <span class="text-gray-500 sm:text-xs font-bold">Rp</span>
                                                        </div>
                                                        <input type="number" :name="`items[${index}][harga_satuan]`" x-model.number="item.harga_satuan" min="0" class="w-full text-sm border-gray-300 rounded focus:ring-emerald-500 focus:border-emerald-500 py-1 pl-8 text-right" required>
                                                    </div>
                                                </td>
                                                <td class="py-2 px-3 text-right font-medium text-gray-700">
                                                    <span x-text="formatRupiah(item.qty * item.harga_satuan)"></span>
                                                </td>
                                                <td class="py-2 px-3 text-center">
                                                    <button type="button" @click="removeItem(index)" class="text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Baris">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot class="bg-gray-50 font-bold">
                                        <tr>
                                            <td colspan="4" class="py-3 px-3 text-right text-gray-600">Total Estimasi:</td>
                                            <td class="py-3 px-3 text-right text-emerald-700 text-lg">
                                                <span x-text="formatRupiah(grandTotal)"></span>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Action Bar -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg z-10 md:static md:bg-transparent md:border-0 md:shadow-none md:p-0 md:mt-6">
                <div class="max-w-7xl mx-auto flex items-center justify-between md:justify-end">
                    <div class="md:hidden text-sm font-bold text-gray-800">
                        Total: <span x-text="formatRupiah(grandTotal)"></span>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('purchasing.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Batal') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-save mr-2"></i> {{ __('Simpan PO') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js Logic -->
    <script>
        function purchaseForm() {
            return {
                items: [
                    { id_stok: '', qty: 1, harga_satuan: 0 }
                ],
                isSubmitting: false,
                addItem() {
                    this.items.push({ id_stok: '', qty: 1, harga_satuan: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    } else {
                        // If it's the last item, just clear it or ask confirmation
                        if(confirm('Hapus baris terakhir?')) {
                             this.items = [];
                        }
                    }
                },
                get grandTotal() {
                    return this.items.reduce((sum, item) => {
                        return sum + (item.qty * item.harga_satuan);
                    }, 0);
                },
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                },
                async submitForm(e) {
                    if (this.isSubmitting) return;

                    // Basic Validation
                    if (this.items.length === 0) {
                        if (!await Swal.fire({
                            title: 'Konfirmasi',
                            text: 'Anda belum menambahkan barang. PO akan dibuat dengan status "Data Masih Kosong". Lanjutkan?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal'
                        }).then(result => result.isConfirmed)) {
                            return;
                        }
                    } else {
                        for (let item of this.items) {
                            if (!item.id_stok || item.qty <= 0) {
                                Swal.fire('Validasi', 'Mohon lengkapi data barang dan pastikan Qty > 0.', 'error');
                                return;
                            }
                        }
                    }

                    this.isSubmitting = true;
                    const form = e.target;
                    const formData = new FormData(form);

                    try {
                        console.log('Submitting form...');
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        });

                        const data = await response.json();
                        console.log('Response:', data);

                        if (response.ok && data.success) {
                            // Success Alert
                            await Swal.fire({
                                title: 'Berhasil!',
                                html: `Purchase Order <strong>${data.data.code}</strong> berhasil dibuat.<br>Apa yang ingin Anda lakukan selanjutnya?`,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: '<i class="fas fa-eye"></i> Lihat Detail PO',
                                cancelButtonText: 'Kembali ke Daftar',
                                confirmButtonColor: '#059669',
                                cancelButtonColor: '#6B7280',
                                timer: 5000,
                                timerProgressBar: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `/purchasing/${data.data.id}`;
                                } else {
                                    window.location.href = data.data.redirect_url;
                                }
                            });
                        } else {
                            // Validation or Server Error
                            let errorMessage = data.message || 'Terjadi kesalahan saat menyimpan data.';
                            if (data.errors) {
                                errorMessage = Object.values(data.errors).flat().join('<br>');
                            }
                            Swal.fire('Gagal', errorMessage, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan jaringan atau server.', 'error');
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>