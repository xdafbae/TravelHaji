<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Purchasing (Purchase Order)') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data pembelian dan stok barang masuk.</p>
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
                                <span class="text-sm font-medium text-gray-500">Purchasing</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <!-- Success Message & PO Creation Alert -->
    @if(session('success'))
        <div class="hidden" id="flash-success-message" 
             data-po-id="{{ session('created_po_id') }}" 
             data-po-code="{{ session('created_po_code') }}">
             {{ session('success') }}
        </div>
    @endif

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- KPI Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total PO -->
            <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total PO</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalPO) }}</h3>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <i class="fas fa-file-invoice fa-lg"></i>
                    </div>
                </div>
            </div>
            
            <!-- Total Amount -->
            <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Nilai</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Helpers\CurrencyHelper::formatRupiah($totalAmount) }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <i class="fas fa-money-bill-wave fa-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Outstanding -->
            <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Belum Lunas</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($outstandingPO) }}</h3>
                    </div>
                    <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                        <i class="fas fa-hourglass-half fa-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Today's PO -->
            <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">PO Hari Ini</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($todayPO) }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <i class="fas fa-calendar-day fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Actions Toolbar -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100" x-data="{ showFilters: false }">
            <div class="flex flex-col md:flex-row justify-between md:items-center space-y-4 md:space-y-0">
                <!-- Search & Toggle Filters -->
                <div class="flex items-center flex-1 space-x-2">
                    <form method="GET" action="{{ route('purchasing.index') }}" class="flex-1 max-w-lg flex items-center">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full text-sm" 
                                placeholder="Cari Kode PO atau Supplier...">
                        </div>
                        <!-- Preserve other filters if any -->
                        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                        @if(request('date_from')) <input type="hidden" name="date_from" value="{{ request('date_from') }}"> @endif
                        @if(request('date_to')) <input type="hidden" name="date_to" value="{{ request('date_to') }}"> @endif
                        
                        <button type="button" @click="showFilters = !showFilters" 
                            class="ml-2 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 focus:outline-none border border-gray-200 text-sm">
                            <i class="fas fa-filter mr-1"></i> <span class="hidden sm:inline">Filter</span>
                        </button>
                    </form>
                </div>

                <!-- Create Button -->
                <div class="flex items-center justify-end">
                    <a href="{{ route('purchasing.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-sm transition-colors text-sm font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Buat PO Baru
                    </a>
                </div>
            </div>

            <!-- Advanced Filters Area (Expandable) -->
            <div x-show="showFilters" class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4" style="display: none;">
                <form method="GET" action="{{ route('purchasing.index') }}" id="filterForm" class="contents">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                            <option value="all">Semua Status</option>
                            <option value="Data Masih Kosong" {{ request('status') == 'Data Masih Kosong' ? 'selected' : '' }}>Data Masih Kosong</option>
                            <option value="Ada Data" {{ request('status') == 'Ada Data' ? 'selected' : '' }}>Ada Data</option>
                            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <!-- Supplier Filter -->
                    <div>
                        <label for="supplier_id" class="block text-xs font-medium text-gray-700 mb-1">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                            <option value="">Semua Supplier</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id_supplier }}" {{ request('supplier_id') == $s->id_supplier ? 'selected' : '' }}>{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <div class="flex space-x-2">
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs">
                                Apply
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Active Filters Chips -->
            @if(request('status') || request('supplier_id') || request('date_from') || request('search'))
            <div class="mt-3 flex flex-wrap gap-2 items-center">
                <span class="text-xs text-gray-500">Filter Aktif:</span>
                
                @if(request('search'))
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700">
                        Search: {{ request('search') }}
                        <a href="{{ route('purchasing.index', request()->except('search')) }}" class="ml-1 hover:text-blue-900"><i class="fas fa-times"></i></a>
                    </span>
                @endif

                @if(request('status') && request('status') !== 'all')
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-700">
                        Status: {{ request('status') }}
                        <a href="{{ route('purchasing.index', request()->except('status')) }}" class="ml-1 hover:text-purple-900"><i class="fas fa-times"></i></a>
                    </span>
                @endif
                
                @if(request('supplier_id'))
                    @php $supName = $suppliers->firstWhere('id_supplier', request('supplier_id'))?->nama_supplier ?? 'Unknown'; @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-700">
                        Supplier: {{ $supName }}
                        <a href="{{ route('purchasing.index', request()->except('supplier_id')) }}" class="ml-1 hover:text-indigo-900"><i class="fas fa-times"></i></a>
                    </span>
                @endif

                <a href="{{ route('purchasing.index') }}" class="text-xs text-gray-500 hover:text-gray-700 underline ml-2">Reset Semua</a>
            </div>
            @endif
        </div>

        <!-- Data List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('purchasing.index', array_merge(request()->query(), ['sort' => 'kode_purchase', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="group flex items-center">
                                    Kode PO
                                    <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                </a>
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('purchasing.index', array_merge(request()->query(), ['sort' => 'waktu_preorder', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="group flex items-center">
                                    Tanggal
                                    <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                </a>
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                <a href="{{ route('purchasing.index', array_merge(request()->query(), ['sort' => 'total_amount', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="group flex items-center justify-end">
                                    Total Amount
                                    <i class="fas fa-sort ml-1 text-gray-300 group-hover:text-gray-500"></i>
                                </a>
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($purchases as $po)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-mono font-medium text-blue-600">{{ $po->kode_purchase }}</span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $po->waktu_preorder ? \Carbon\Carbon::parse($po->waktu_preorder)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 mr-3">
                                        <i class="fas fa-truck text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $po->supplier->nama_supplier ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-gray-800">
                                {{ \App\Helpers\CurrencyHelper::formatRupiah($po->total_amount) }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $statusConfig = match($po->status) {
                                        'Lunas' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                        'Ada Data' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-info-circle'],
                                        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-circle']
                                    };
                                @endphp
                                <span class="{{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} py-1 px-3 rounded-full text-xs font-medium inline-flex items-center">
                                    <i class="fas {{ $statusConfig['icon'] }} mr-1.5"></i>
                                    {{ $po->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('purchasing.show', $po->id_purchase) }}" 
                                       class="p-2 bg-white border border-gray-200 rounded-lg text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all" 
                                       title="Detail / Kelola Item">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('purchasing.edit', $po->id_purchase) }}" 
                                       class="p-2 bg-white border border-gray-200 rounded-lg text-yellow-600 hover:bg-yellow-50 hover:border-yellow-200 transition-all" 
                                       title="Edit Header">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('purchasing.destroy', $po->id_purchase) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus PO {{ $po->kode_purchase }}? Data yang dihapus tidak dapat dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-white border border-gray-200 rounded-lg text-red-600 hover:bg-red-50 hover:border-red-200 transition-all" 
                                                title="Hapus PO">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <div class="bg-gray-100 p-4 rounded-full mb-3">
                                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-lg font-medium">Tidak ada data Purchase Order ditemukan.</p>
                                    <p class="text-sm">Coba sesuaikan filter pencarian atau buat PO baru.</p>
                                    <a href="{{ route('purchasing.create') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                        Buat PO Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View (Visible on < md) -->
            <div class="md:hidden">
                <div class="divide-y divide-gray-200">
                    @forelse($purchases as $po)
                    <div class="p-4 bg-white space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-mono text-sm font-bold text-blue-600 block">{{ $po->kode_purchase }}</span>
                                <span class="text-xs text-gray-500">{{ $po->waktu_preorder ? \Carbon\Carbon::parse($po->waktu_preorder)->format('d M Y') : '-' }}</span>
                            </div>
                            @php
                                $statusClass = match($po->status) {
                                    'Lunas' => 'bg-green-100 text-green-800',
                                    'Ada Data' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="{{ $statusClass }} py-1 px-2 rounded text-xs font-medium">
                                {{ $po->status }}
                            </span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="fas fa-store text-gray-400 w-5"></i>
                            <span class="truncate">{{ $po->supplier->nama_supplier ?? '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100 mt-2">
                            <span class="text-sm font-bold text-gray-900">{{ \App\Helpers\CurrencyHelper::formatRupiah($po->total_amount) }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('purchasing.show', $po->id_purchase) }}" class="p-2 text-blue-600 bg-blue-50 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('purchasing.edit', $po->id_purchase) }}" class="p-2 text-yellow-600 bg-yellow-50 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('purchasing.destroy', $po->id_purchase) }}" method="POST" onsubmit="return confirm('Hapus PO ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 bg-red-50 rounded">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-search text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak ada data ditemukan.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMsg = document.getElementById('flash-success-message');
            if (successMsg) {
                const poId = successMsg.getAttribute('data-po-id');
                const poCode = successMsg.getAttribute('data-po-code');
                const message = successMsg.innerText;

                // If specific PO creation data exists, show the advanced alert with actions
                if (poId && poCode) {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: `Purchase Order <strong>${poCode}</strong> berhasil dibuat.<br>Apa yang ingin Anda lakukan selanjutnya?`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-eye"></i> Lihat Detail PO',
                        cancelButtonText: 'Kembali ke Daftar',
                        confirmButtonColor: '#059669', // Emerald-600
                        cancelButtonColor: '#6B7280', // Gray-500
                        timer: 5000,
                        timerProgressBar: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/purchasing/${poId}`;
                        }
                    });
                } else {
                    // Standard toast for other success actions (delete/update)
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: message,
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            }
        });
    </script>
</x-app-layout>