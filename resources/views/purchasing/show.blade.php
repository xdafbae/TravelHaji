<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Purchase Order') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Ref: <span class="font-mono font-bold text-blue-600">{{ $purchase->kode_purchase }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-2">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-print mr-2"></i> Print / PDF
                </button>
                <a href="{{ route('purchasing.edit', $purchase->id_purchase) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Success Message (SweetAlert Integration Check) -->
    @if(session('success'))
        <div class="hidden" id="flash-success-message">{{ session('success') }}</div>
    @endif

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 print:p-0 print:m-0 print:max-w-none">
        
        <!-- Main Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 print:shadow-none print:border-0">
            
            <!-- Header Status Section -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center print:bg-white print:border-b-2">
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Status Pesanan</span>
                    <div class="mt-1">
                        @php
                            $statusClass = match($purchase->status) {
                                'Lunas' => 'bg-green-100 text-green-800 border-green-200',
                                'Ada Data' => 'bg-blue-100 text-blue-800 border-blue-200',
                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                            };
                        @endphp
                        <span class="{{ $statusClass }} px-3 py-1 rounded-full text-sm font-semibold border">
                            {{ $purchase->status }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal PO</span>
                    <div class="mt-1 font-medium text-gray-900">
                        {{ date('d F Y', strtotime($purchase->waktu_preorder)) }}
                    </div>
                </div>
            </div>

            <div class="p-8 print:p-0 print:mt-4">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Supplier Info -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 border-b pb-1">Supplier</h3>
                        <div class="text-gray-900">
                            <p class="font-bold text-lg">{{ $purchase->supplier->nama_supplier }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $purchase->supplier->alamat ?? 'Alamat tidak tersedia' }}</p>
                            <p class="text-sm text-gray-600 mt-1"><i class="fas fa-phone-alt mr-2 text-gray-400"></i> {{ $purchase->supplier->kontak ?? '-' }}</p>
                            <p class="text-sm text-gray-600"><i class="fas fa-envelope mr-2 text-gray-400"></i> {{ $purchase->supplier->email ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Company/Internal Info (Mockup) -->
                    <div class="md:text-right">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 border-b pb-1">Dikirim Ke</h3>
                        <div class="text-gray-900">
                            <p class="font-bold text-lg">TravelH Warehouse</p>
                            <p class="text-sm text-gray-600 mt-1">Jl. Contoh No. 123</p>
                            <p class="text-sm text-gray-600 mt-1">Jakarta, Indonesia</p>
                            
                            @if($purchase->tgl_barang_datang)
                            <div class="mt-4 inline-block bg-yellow-50 px-3 py-2 rounded border border-yellow-200 text-left">
                                <p class="text-xs text-yellow-800 font-bold uppercase">Estimasi Kedatangan</p>
                                <p class="text-sm text-yellow-900">{{ date('d M Y', strtotime($purchase->tgl_barang_datang)) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($purchase->keterangan)
                <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 print:bg-transparent print:border print:border-gray-300">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan / Keterangan</h4>
                    <p class="text-sm text-gray-700 italic">"{{ $purchase->keterangan }}"</p>
                </div>
                @endif

                <!-- Items Table -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Detail Item</h3>
                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 print:bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($purchase->details as $index => $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $detail->stok->nama_barang }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $detail->stok->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($detail->qty) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ \App\Helpers\CurrencyHelper::formatRupiah($detail->harga_satuan) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 text-right">{{ \App\Helpers\CurrencyHelper::formatRupiah($detail->subtotal) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Tidak ada item dalam PO ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 print:bg-gray-100">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-gray-600 uppercase">Total Amount</td>
                                    <td class="px-6 py-4 text-right text-lg font-bold text-emerald-600">{{ \App\Helpers\CurrencyHelper::formatRupiah($purchase->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Approval / Actions Section (Non-Print) -->
                <div class="print:hidden border-t border-gray-200 pt-6 mt-6">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Actions</h4>
                    <div class="flex flex-wrap gap-3">
                        @if($purchase->status != 'Lunas')
                            <form action="{{ route('purchasing.update', $purchase->id_purchase) }}" method="POST" onsubmit="return confirm('Tandai sebagai Lunas? Stok akan bertambah otomatis.')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_supplier" value="{{ $purchase->id_supplier }}">
                                <input type="hidden" name="waktu_preorder" value="{{ $purchase->waktu_preorder }}">
                                <input type="hidden" name="status" value="Lunas">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none transition ease-in-out duration-150">
                                    <i class="fas fa-check-circle mr-2"></i> Approve / Mark as Paid
                                </button>
                            </form>
                        @else
                            <button disabled class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest cursor-not-allowed">
                                <i class="fas fa-check-double mr-2"></i> Sudah Lunas
                            </button>
                        @endif

                        <form action="{{ route('purchasing.destroy', $purchase->id_purchase) }}" method="POST" onsubmit="return confirm('Hapus PO ini permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none transition ease-in-out duration-150">
                                <i class="fas fa-trash-alt mr-2"></i> Delete PO
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMsg = document.getElementById('flash-success-message');
            if (successMsg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMsg.innerText,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .py-6 {
                padding: 0 !important;
            }
            .max-w-7xl {
                max-width: none !important;
            }
            .print\:p-0, .print\:p-0 * {
                visibility: visible;
            }
            .print\:p-0 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .print\:hidden {
                display: none !important;
            }
        }
    </style>
</x-app-layout>