<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Header & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div class="space-y-1">
                <nav class="flex text-sm font-medium text-secondary-500 mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary-800">Manajemen Paspor</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight leading-tight">
                    Manajemen Paspor
                </h2>
                <p class="text-sm text-secondary-500 font-medium max-w-2xl">
                    Kelola data paspor jamaah, pantau masa berlaku, dan update status pengajuan visa.
                </p>
            </div>
            
            <a href="{{ route('passport.create') }}" class="inline-flex items-center px-5 py-3 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-2.5 group-hover:bg-white/30 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                Tambah Paspor
            </a>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Paspor -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-book text-8xl text-primary-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl shadow-sm border border-primary-100">
                            <i class="fas fa-passport"></i>
                        </div>
                        <h3 class="text-xs font-bold text-secondary-500 uppercase tracking-wider">Total<br>Paspor</h3>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-secondary-900 tracking-tight">{{ $stats['total'] }}</span>
                        <span class="text-xs font-medium text-secondary-500 ml-1">Dokumen</span>
                    </div>
                </div>
            </div>

            <!-- Visa Pending -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-clock text-8xl text-warning-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-warning-50 text-warning-600 flex items-center justify-center text-xl shadow-sm border border-warning-100">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h3 class="text-xs font-bold text-secondary-500 uppercase tracking-wider">Visa<br>Pending</h3>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-secondary-900 tracking-tight">{{ $stats['pending'] }}</span>
                        <span class="text-xs font-medium text-secondary-500 ml-1">Jamaah</span>
                    </div>
                </div>
            </div>

            <!-- Visa Approved -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-check-circle text-8xl text-success-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-success-50 text-success-600 flex items-center justify-center text-xl shadow-sm border border-success-100">
                            <i class="fas fa-stamp"></i>
                        </div>
                        <h3 class="text-xs font-bold text-secondary-500 uppercase tracking-wider">Visa<br>Approved</h3>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-secondary-900 tracking-tight">{{ $stats['approved'] }}</span>
                        <span class="text-xs font-medium text-secondary-500 ml-1">Jamaah</span>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-exclamation-triangle text-8xl text-danger-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-danger-50 text-danger-600 flex items-center justify-center text-xl shadow-sm border border-danger-100">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3 class="text-xs font-bold text-secondary-500 uppercase tracking-wider">Expired<br>< 6 Bulan</h3>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-secondary-900 tracking-tight">{{ $stats['expired_soon'] }}</span>
                        <span class="text-xs font-medium text-secondary-500 ml-1">Dokumen</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden flex flex-col">
            
            <!-- Toolbar -->
            <div class="p-5 border-b border-secondary-100 bg-secondary-50/30 flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Search Box -->
                <div class="relative w-full lg:w-96 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-secondary-400 group-focus-within:text-primary-500 transition-colors"></i>
                    </div>
                    <form action="{{ route('passport.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="block w-full pl-11 pr-4 py-3 border-secondary-200 rounded-xl leading-5 bg-white placeholder-secondary-400 focus:outline-none focus:placeholder-secondary-300 focus:border-primary-500 focus:ring-primary-500 sm:text-sm transition-all shadow-sm hover:border-secondary-300" 
                               placeholder="Cari nama, nomor paspor, atau kode jamaah...">
                    </form>
                </div>

                <!-- Right Actions & Filters -->
                <div class="flex items-center gap-3 w-full lg:w-auto justify-end overflow-x-auto pb-1 lg:pb-0">
                    <div class="flex bg-secondary-100/50 p-1 rounded-xl border border-secondary-200">
                        @foreach(['' => 'Semua', 'Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'] as $key => $label)
                            <button type="button" onclick="window.location.href='{{ route('passport.index', ['status' => $key]) }}'" 
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap {{ request('status') == $key ? 'bg-white text-secondary-900 shadow-sm ring-1 ring-secondary-200' : 'text-secondary-500 hover:text-secondary-700 hover:bg-secondary-200/50' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Table View -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-100">
                    <thead class="bg-secondary-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Jamaah</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Detail Paspor</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Masa Berlaku</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Status Visa</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-secondary-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-100">
                        @forelse($passports as $p)
                        <tr class="hover:bg-secondary-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-100 to-info-200 flex items-center justify-center text-primary-700 font-bold text-sm border-2 border-white shadow-sm">
                                            {{ substr($p->nama_passport, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-secondary-900 group-hover:text-primary-700 transition-colors">{{ $p->nama_passport }}</div>
                                        <div class="text-xs text-secondary-500 font-mono bg-secondary-100 px-1.5 py-0.5 rounded inline-block mt-0.5">{{ $p->jamaah->kode_jamaah ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="flex items-center text-sm font-bold text-secondary-900 font-mono mb-1">
                                        <i class="fas fa-passport text-secondary-400 mr-2 text-xs"></i>
                                        {{ $p->no_passport }}
                                    </div>
                                    <div class="text-xs text-secondary-500">
                                        {{ $p->birth_city }}, {{ $p->birth_date->format('d/m/Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $isExpiring = $p->date_expire < now()->addMonths(6);
                                    $isExpired = $p->date_expire < now();
                                @endphp
                                <div class="flex flex-col">
                                    <div class="text-xs font-bold text-secondary-500 mb-0.5">Berlaku s/d</div>
                                    <div class="flex items-center text-sm font-bold {{ $isExpired ? 'text-danger-600' : ($isExpiring ? 'text-warning-600' : 'text-secondary-900') }}">
                                        {{ $p->date_expire->format('d M Y') }}
                                        @if($isExpired)
                                            <span class="ml-2 w-2 h-2 rounded-full bg-danger-500" title="Expired"></span>
                                        @elseif($isExpiring)
                                            <span class="ml-2 w-2 h-2 rounded-full bg-warning-500" title="Expiring Soon"></span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = match($p->status_visa) {
                                        'Approved' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'border' => 'border-success-200', 'icon' => 'fa-check-circle'],
                                        'Issued' => ['bg' => 'bg-info-50', 'text' => 'text-info-700', 'border' => 'border-info-200', 'icon' => 'fa-stamp'],
                                        'Rejected' => ['bg' => 'bg-danger-50', 'text' => 'text-danger-700', 'border' => 'border-danger-200', 'icon' => 'fa-times-circle'],
                                        'Pending' => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'border' => 'border-warning-200', 'icon' => 'fa-clock'],
                                        default => ['bg' => 'bg-secondary-50', 'text' => 'text-secondary-700', 'border' => 'border-secondary-200', 'icon' => 'fa-circle'],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    <i class="fas {{ $statusConfig['icon'] }} mr-1.5"></i>
                                    {{ $p->status_visa }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @if($p->scan_passport)
                                    <a href="{{ asset('storage/' . $p->scan_passport) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg text-secondary-400 hover:text-primary-600 hover:bg-primary-50 transition-all border border-transparent hover:border-primary-100" title="Lihat Scan">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                    
                                    <a href="{{ route('passport.edit', $p->id_passport) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-secondary-400 hover:text-warning-600 hover:bg-warning-50 transition-all border border-transparent hover:border-warning-100" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <button onclick="confirmDelete('{{ $p->id_passport }}')" class="w-8 h-8 flex items-center justify-center rounded-lg text-secondary-400 hover:text-danger-600 hover:bg-danger-50 transition-all border border-transparent hover:border-danger-100" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $p->id_passport }}" action="{{ route('passport.destroy', $p->id_passport) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-secondary-50 rounded-full flex items-center justify-center mb-4 border border-secondary-100">
                                        <i class="fas fa-passport text-3xl text-secondary-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-secondary-900">Belum ada data paspor</h3>
                                    <p class="text-sm text-secondary-500 mt-1 max-w-xs mx-auto">Mulai dengan menambahkan data paspor jamaah baru ke dalam sistem.</p>
                                    <a href="{{ route('passport.create') }}" class="mt-4 text-primary-600 font-bold hover:text-primary-700 text-sm flex items-center">
                                        <i class="fas fa-plus mr-2"></i> Tambah Paspor
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-secondary-100 bg-secondary-50/50">
                {{ $passports->links() }}
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    iconColor: '#10b981',
                    customClass: {
                        popup: 'rounded-xl border border-secondary-100 shadow-lg',
                        title: 'text-sm font-bold text-secondary-900',
                        htmlContainer: 'text-xs text-secondary-500'
                    }
                });
            });
        </script>
    @endif
    
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data Paspor?',
                text: "Data ini akan dihapus permanen dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#f3f4f6',
                cancelButtonText: '<span class="text-secondary-700 font-bold">Batal</span>',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>