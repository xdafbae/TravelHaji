<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
         
        <!-- Welcome Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-1">
                <h2 class="text-3xl font-black text-secondary-900 tracking-tight leading-tight">
                    Dashboard Overview
                </h2>
                <div class="flex items-center text-secondary-500 font-medium">
                    <span>Selamat datang kembali,</span>
                    <span class="ml-1 text-secondary-900 font-bold bg-secondary-100 px-2 py-0.5 rounded-lg border border-secondary-200">{{ Auth::user()->name }}</span>
                    <span class="mx-2 text-secondary-300">|</span>
                    <span class="text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <div class="hidden md:flex items-center bg-white border border-secondary-200 rounded-xl p-1 shadow-sm">
                    <span class="px-3 py-1.5 text-xs font-bold text-secondary-600 bg-secondary-50 rounded-lg border border-secondary-100">
                        <i class="fas fa-clock mr-1.5 text-primary-500"></i> {{ now()->format('H:i') }} WIB
                    </span>
                </div>
                <button onclick="refreshDashboard()" class="group relative flex items-center justify-center p-3 bg-white border border-secondary-200 rounded-xl text-secondary-400 hover:text-primary-600 hover:border-primary-200 hover:shadow-md transition-all duration-300 w-12 h-12" title="Refresh Data">
                    <i class="fas fa-sync-alt transform group-hover:rotate-180 transition-transform duration-700" id="refresh-icon"></i>
                </button>
                <a href="{{ route('jamaah.create') }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-5 py-3 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                    <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                    Jamaah Baru
                </a>
            </div>
        </div>

        <div class="animate-fade-in-up space-y-8">
            
            <!-- Stats Grid -->
            <div id="stats-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Jamaah -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 hover:shadow-lg hover:border-primary-100 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                        <i class="fas fa-users text-8xl text-primary-600"></i>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 text-primary-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider">Total Jamaah</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-bold text-success-600 bg-success-50 px-1.5 py-0.5 rounded flex items-center">
                                        <i class="fas fa-arrow-up mr-1 text-[10px]"></i> 12%
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-secondary-900 tracking-tight mt-4" id="stat-total-jamaah">{{ number_format($stats['total_jamaah']) }}</h3>
                    </div>
                </div>

                <!-- Active Jamaah -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 hover:shadow-lg hover:border-info-100 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                        <i class="fas fa-user-clock text-8xl text-info-600"></i>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-info-50 to-info-100 text-info-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider">Menunggu Jadwal</p>
                                <p class="text-xs font-medium text-secondary-500 mt-0.5">Siap diberangkatkan</p>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-secondary-900 tracking-tight mt-4" id="stat-active-jamaah">{{ number_format($stats['active_jamaah']) }}</h3>
                    </div>
                </div>

                <!-- Saldo Kas -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 hover:shadow-lg hover:border-warning-100 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                        <i class="fas fa-wallet text-8xl text-warning-600"></i>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-warning-50 to-warning-100 text-warning-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider">Saldo Kas</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-bold {{ $stats['kas_masuk_month'] >= $stats['kas_keluar_month'] ? 'text-success-600 bg-success-50' : 'text-danger-600 bg-danger-50' }} px-1.5 py-0.5 rounded flex items-center">
                                        {{ $stats['kas_masuk_month'] >= $stats['kas_keluar_month'] ? 'Surplus' : 'Defisit' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-secondary-900 tracking-tight mt-4 truncate" id="stat-saldo">Rp {{ number_format($stats['saldo_kas'], 0, ',', '.') }}</h3>
                    </div>
                </div>

                <!-- Next Departure -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 hover:shadow-lg hover:border-purple-100 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                        <i class="fas fa-plane-departure text-8xl text-purple-600"></i>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fas fa-plane-departure"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider">Next Departure</p>
                                @if($upcomingDeparture)
                                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded mt-0.5 inline-block">
                                        {{ $upcomingDeparture->kota_keberangkatan }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-xl font-black text-secondary-900 tracking-tight mt-4 leading-tight">
                            {{ $upcomingDeparture ? $upcomingDeparture->waktu_keberangkatan->format('d M Y') : 'Belum ada jadwal' }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Left: Analytics & Quick Actions -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Analytics Chart -->
                    <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 p-6 lg:p-8">
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-secondary-900 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-primary-500 rounded-full"></span>
                                    Analisis Pertumbuhan
                                </h3>
                                <p class="text-sm text-secondary-500 ml-4 mt-1">Tren pendaftaran jamaah dan pendapatan</p>
                            </div>
                            <div class="flex bg-secondary-50 p-1 rounded-xl border border-secondary-100">
                                <button onclick="updateChartFilter('month')" id="btn-month" class="px-4 py-2 rounded-lg text-xs font-bold transition-all bg-white text-secondary-900 shadow-sm">Bulan Ini</button>
                                <button onclick="updateChartFilter('year')" id="btn-year" class="px-4 py-2 rounded-lg text-xs font-bold transition-all text-secondary-500 hover:text-secondary-700">Tahun Ini</button>
                            </div>
                            <select id="chart-filter" onchange="loadChartData()" class="hidden">
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
                        </div>
                        <div class="relative h-[350px] w-full">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('jamaah.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-3xl bg-white border border-secondary-100 shadow-sm hover:shadow-md hover:border-primary-200 transition-all duration-300">
                            <div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="font-bold text-secondary-700 group-hover:text-primary-700 transition-colors">Data Jamaah</span>
                            <span class="text-xs text-secondary-400 mt-1">Kelola database</span>
                        </a>
                        
                        <a href="{{ route('finance.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-3xl bg-white border border-secondary-100 shadow-sm hover:shadow-md hover:border-success-200 transition-all duration-300">
                            <div class="w-14 h-14 rounded-2xl bg-success-50 text-success-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 group-hover:bg-success-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <span class="font-bold text-secondary-700 group-hover:text-success-700 transition-colors">Keuangan</span>
                            <span class="text-xs text-secondary-400 mt-1">Catat transaksi</span>
                        </a>

                        <a href="{{ route('embarkasi.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-3xl bg-white border border-secondary-100 shadow-sm hover:shadow-md hover:border-info-200 transition-all duration-300">
                            <div class="w-14 h-14 rounded-2xl bg-info-50 text-info-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 group-hover:bg-info-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-plane"></i>
                            </div>
                            <span class="font-bold text-secondary-700 group-hover:text-info-700 transition-colors">Jadwal</span>
                            <span class="text-xs text-secondary-400 mt-1">Atur keberangkatan</span>
                        </a>

                        <a href="{{ route('inventory.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-3xl bg-white border border-secondary-100 shadow-sm hover:shadow-md hover:border-warning-200 transition-all duration-300">
                            <div class="w-14 h-14 rounded-2xl bg-warning-50 text-warning-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 group-hover:bg-warning-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <span class="font-bold text-secondary-700 group-hover:text-warning-700 transition-colors">Logistik</span>
                            <span class="text-xs text-secondary-400 mt-1">Stok barang</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Notifications & Activity -->
                <div class="space-y-8">
                    <!-- Alert Card -->
                    @if($stats['passport_pending'] > 0)
                    <div class="bg-gradient-to-br from-warning-50 to-white rounded-3xl shadow-sm border border-warning-100 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-warning-100 rounded-full -mr-12 -mt-12 opacity-50 blur-2xl"></div>
                        <div class="flex gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-warning-100 text-warning-600 flex items-center justify-center text-xl flex-shrink-0 shadow-sm">
                                <i class="fas fa-passport"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary-900 text-lg">Perhatian Diperlukan</h4>
                                <p class="text-sm text-secondary-600 mt-1 leading-relaxed">
                                    Terdapat <span class="font-bold text-warning-700">{{ $stats['passport_pending'] }} paspor jamaah</span> yang membutuhkan verifikasi atau tindak lanjut.
                                </p>
                                <a href="{{ route('passport.index', ['status' => 'Pending']) }}" class="inline-flex items-center mt-3 text-sm font-bold text-warning-700 hover:text-warning-800 transition-colors">
                                    Proses Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Activity Feed -->
                    <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 flex flex-col h-[500px]">
                        <div class="p-6 border-b border-secondary-100 flex justify-between items-center bg-secondary-50/30 rounded-t-3xl backdrop-blur-sm">
                            <h3 class="font-bold text-secondary-900 flex items-center gap-2">
                                <i class="fas fa-history text-secondary-400"></i> Aktivitas Terbaru
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-success-500"></span>
                                </span>
                                <span class="text-xs font-bold text-secondary-500">Live</span>
                            </div>
                        </div>
                        <div class="p-0 overflow-y-auto flex-1 custom-scrollbar relative">
                            <div class="absolute left-8 top-6 bottom-6 w-0.5 bg-secondary-100"></div>
                            <ul class="relative py-6 pr-6 pl-2 space-y-6">
                                @forelse($recentActivities as $activity)
                                <li class="relative pl-10 group cursor-default">
                                    <div class="absolute left-[21px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-{{ $activity['color'] }}-500 z-10 group-hover:scale-125 group-hover:bg-{{ $activity['color'] }}-50 transition-all duration-300"></div>
                                    <div class="bg-white p-4 rounded-2xl border border-secondary-100 shadow-sm group-hover:shadow-md group-hover:border-{{ $activity['color'] }}-200 transition-all duration-300 ml-2 relative">
                                        <div class="absolute left-[-6px] top-4 w-3 h-3 bg-white border-l border-t border-secondary-100 transform -rotate-45 group-hover:border-{{ $activity['color'] }}-200 transition-colors"></div>
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-{{ $activity['color'] }}-600 bg-{{ $activity['color'] }}-50 px-2 py-0.5 rounded-lg">{{ $activity['title'] }}</span>
                                            <span class="text-[10px] font-bold text-secondary-400">{{ $activity['time'] }}</span>
                                        </div>
                                        <p class="text-sm text-secondary-700 font-medium leading-relaxed">{{ $activity['description'] }}</p>
                                    </div>
                                </li>
                                @empty
                                <li class="text-center py-12">
                                    <div class="w-16 h-16 bg-secondary-50 rounded-full flex items-center justify-center mx-auto mb-3 text-secondary-300">
                                        <i class="fas fa-stream text-2xl"></i>
                                    </div>
                                    <p class="text-secondary-400 font-medium text-sm">Belum ada aktivitas tercatat hari ini.</p>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="p-4 border-t border-secondary-100 bg-secondary-50/30 rounded-b-3xl text-center">
                            <a href="#" class="text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-wider flex items-center justify-center gap-2 group">
                                Lihat Semua Log <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js & Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 20px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>

    <script>
        // --- UI Interactions ---
        function updateChartFilter(type) {
            document.getElementById('chart-filter').value = type;
            loadChartData();
            
            // Toggle active styles
            const btnMonth = document.getElementById('btn-month');
            const btnYear = document.getElementById('btn-year');
            
            if(type === 'month') {
                btnMonth.className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all bg-white text-secondary-900 shadow-sm';
                btnYear.className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all text-secondary-500 hover:text-secondary-700';
            } else {
                btnYear.className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all bg-white text-secondary-900 shadow-sm';
                btnMonth.className = 'px-4 py-2 rounded-lg text-xs font-bold transition-all text-secondary-500 hover:text-secondary-700';
            }
        }

        // --- Drag and Drop ---
        document.addEventListener('DOMContentLoaded', function() {
            new Sortable(document.getElementById('stats-container'), {
                animation: 200,
                ghostClass: 'opacity-50',
                delay: 150,
                delayOnTouchOnly: true
            });

            initChart();
            setInterval(fetchRealTimeStats, 30000);
        });

        // --- Chart Logic ---
        let mainChart;
        function initChart() {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#64748b';
            
            // Create Gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)'); // success-500
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

            mainChart = new Chart(ctx, {
                type: 'line',
                data: { labels: [], datasets: [] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                            ticks: { font: { size: 11, weight: '600' }, padding: 10 }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11, weight: '600' }, padding: 10 }
                        }
                    },
                    elements: {
                        line: { tension: 0.4, borderWidth: 3 },
                        point: { radius: 0, hoverRadius: 6, borderWidth: 3, backgroundColor: '#ffffff' }
                    }
                }
            });

            loadChartData();
        }

        function loadChartData() {
            const range = document.getElementById('chart-filter').value;
            
            fetch(`{{ route('dashboard.chart') }}?range=${range}`)
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('mainChart').getContext('2d');
                    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)'); 
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                    const dataset = data.jamaah.datasets[0];
                    dataset.borderColor = '#10b981'; // success-500
                    dataset.backgroundColor = gradient;
                    dataset.pointBackgroundColor = '#ffffff';
                    dataset.pointBorderColor = '#10b981';
                    dataset.fill = true;

                    mainChart.data.labels = data.jamaah.labels;
                    mainChart.data.datasets = [dataset];
                    mainChart.update();
                })
                .catch(error => console.error('Chart Error:', error));
        }

        // --- Real-time Stats ---
        function refreshDashboard() {
            const icon = document.getElementById('refresh-icon');
            icon.classList.add('animate-spin');
            
            Promise.all([fetchRealTimeStats(), loadChartData()])
                .finally(() => {
                    setTimeout(() => icon.classList.remove('animate-spin'), 800);
                });
        }

        function fetchRealTimeStats() {
            return fetch(`{{ route('dashboard.stats') }}`)
                .then(response => response.json())
                .then(data => {
                    const stats = data.stats;
                    animateValue("stat-total-jamaah", parseInt(document.getElementById("stat-total-jamaah").innerText.replace(/,/g, '')), stats.total_jamaah, 1000);
                    animateValue("stat-active-jamaah", parseInt(document.getElementById("stat-active-jamaah").innerText.replace(/,/g, '')), stats.active_jamaah, 1000);
                    
                    const formattedSaldo = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(stats.saldo_kas);
                    document.getElementById("stat-saldo").innerText = formattedSaldo.replace('Rp', 'Rp ');
                });
        }

        function animateValue(id, start, end, duration) {
            if (start === end) return;
            const range = end - start;
            let current = start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            const obj = document.getElementById(id);
            
            const timer = setInterval(function() {
                current += increment;
                obj.innerHTML = new Intl.NumberFormat('id-ID').format(current);
                if (current == end) clearInterval(timer);
            }, stepTime > 0 ? stepTime : 10);
        }
    </script>
</x-app-layout>