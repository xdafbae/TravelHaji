<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                    <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i> {{ now()->format('d M Y') }}
                </span>
                <button onclick="refreshDashboard()" class="p-2 bg-white rounded-full text-gray-400 hover:text-indigo-600 shadow-sm border border-gray-100 transition-colors" title="Refresh Data">
                    <i class="fas fa-sync-alt" id="refresh-icon"></i>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Stats Section -->
            <div id="stats-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Jamaah -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-emerald-500 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Jamaah</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-total-jamaah">{{ $stats['total_jamaah'] }}</h3>
                            </div>
                            <div class="p-3 bg-emerald-100 rounded-full text-emerald-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="text-emerald-500 flex items-center font-medium">
                                <i class="fas fa-arrow-up mr-1"></i> 12%
                            </span>
                            <span class="text-gray-400 ml-2">dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Active Jamaah -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Belum Berangkat</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-active-jamaah">{{ $stats['active_jamaah'] }}</h3>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                                <i class="fas fa-user-clock text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="text-gray-500">Menunggu jadwal keberangkatan</span>
                        </div>
                    </div>
                </div>

                <!-- Saldo Kas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-yellow-500 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Saldo Kas</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-saldo">Rp {{ number_format($stats['saldo_kas'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                                <i class="fas fa-wallet text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            <span class="text-{{ $stats['kas_masuk_month'] >= $stats['kas_keluar_month'] ? 'emerald' : 'red' }}-500 flex items-center font-medium">
                                <i class="fas fa-exchange-alt mr-1"></i> 
                                {{ $stats['kas_masuk_month'] >= $stats['kas_keluar_month'] ? 'Surplus' : 'Defisit' }}
                            </span>
                            <span class="text-gray-400 ml-2">bulan ini</span>
                        </div>
                    </div>
                </div>

                <!-- Next Departure / Passport Info -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Keberangkatan</p>
                                <h3 class="text-lg font-bold text-gray-800 mt-1">
                                    {{ $upcomingDeparture ? $upcomingDeparture->waktu_keberangkatan->format('d M Y') : 'Belum ada jadwal' }}
                                </h3>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                                <i class="fas fa-plane-departure text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm">
                            @if($upcomingDeparture)
                                <span class="text-purple-600 bg-purple-50 px-2 py-0.5 rounded text-xs font-semibold">
                                    {{ $upcomingDeparture->kota_keberangkatan }}
                                </span>
                            @else
                                <span class="text-gray-400">Siap menjadwalkan?</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Charts & Performance -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Analytics Chart -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Analisis Pertumbuhan</h3>
                            <select id="chart-filter" onchange="loadChartData()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="month">Tahun Ini (Bulanan)</option>
                                <option value="year">5 Tahun Terakhir</option>
                            </select>
                        </div>
                        <div class="relative h-72 w-full">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions Grid -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Akses Cepat</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('jamaah.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 hover:shadow-sm transition-all group">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-user-plus text-emerald-500 text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-700">Daftar Jamaah</span>
                            </a>
                            
                            <a href="{{ route('finance.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 hover:shadow-sm transition-all group">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cash-register text-blue-500 text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Catat Transaksi</span>
                            </a>

                            <a href="{{ route('embarkasi.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-purple-50 hover:border-purple-200 hover:shadow-sm transition-all group">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-plane text-purple-500 text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Jadwal Baru</span>
                            </a>

                            <a href="{{ route('finance.report') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-yellow-50 hover:border-yellow-200 hover:shadow-sm transition-all group">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-file-alt text-yellow-500 text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-yellow-700">Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Recent Activity & Notifications -->
                <div class="space-y-6">
                    <!-- Notifications / Important Info -->
                    @if($stats['passport_pending'] > 0)
                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl shadow-sm border border-orange-100 p-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-orange-500 text-xl mt-1"></i>
                            </div>
                            <div class="ml-3 w-full">
                                <h3 class="text-sm font-bold text-orange-800">Perhatian Diperlukan</h3>
                                <div class="mt-2 text-sm text-orange-700">
                                    <p>Terdapat <span class="font-bold">{{ $stats['passport_pending'] }}</span> paspor jamaah yang masih berstatus Pending.</p>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('passport.index', ['status' => 'Pending']) }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 hover:underline">
                                        Lihat Data Paspor <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Recent Activity Feed -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full max-h-[500px]">
                        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                            <h3 class="font-bold text-gray-800">Aktivitas Terbaru</h3>
                            <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border">Real-time</span>
                        </div>
                        <div class="p-5 overflow-y-auto flex-1 custom-scrollbar" id="activity-feed">
                            <ul class="space-y-5">
                                @forelse($recentActivities as $activity)
                                <li class="relative pl-6 border-l-2 border-gray-200 hover:border-indigo-300 transition-colors">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-{{ $activity['color'] }}-100 border-2 border-{{ $activity['color'] }}-500 flex items-center justify-center">
                                    </div>
                                    <div class="mb-1 flex justify-between items-start">
                                        <span class="text-xs font-bold text-{{ $activity['color'] }}-600 bg-{{ $activity['color'] }}-50 px-2 py-0.5 rounded">{{ $activity['title'] }}</span>
                                        <span class="text-xs text-gray-400">{{ $activity['time'] }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 font-medium">{{ $activity['description'] }}</p>
                                </li>
                                @empty
                                <li class="text-center text-gray-500 py-4">Belum ada aktivitas tercatat.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl text-center">
                            <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Lihat Semua Aktivitas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>

    <script>
        // --- Drag and Drop Initialization ---
        document.addEventListener('DOMContentLoaded', function() {
            // Make stats grid sortable
            new Sortable(document.getElementById('stats-container'), {
                animation: 150,
                ghostClass: 'bg-indigo-50',
                handle: '.bg-white', // Drag by the card itself
                delay: 200, // Slight delay to prevent accidental drags on touch
                delayOnTouchOnly: true
            });

            // Initialize Charts
            initChart();
            
            // Auto refresh stats every 30 seconds
            setInterval(fetchRealTimeStats, 30000);
        });

        // --- Chart.js Logic ---
        let mainChart;
        function initChart() {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            // Initial Empty Chart
            mainChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1f2937',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4],
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Load Initial Data
            loadChartData();
        }

        function loadChartData() {
            const range = document.getElementById('chart-filter').value;
            
            fetch(`{{ route('dashboard.chart') }}?range=${range}`)
                .then(response => response.json())
                .then(data => {
                    // Decide what to show based on requirements. 
                    // Let's mix Jamaah and Finance or create a dual axis chart.
                    // For simplicity, let's show Jamaah Growth + Income for now
                    // Or user can toggle. Let's merge datasets for the 'Overview'.
                    
                    // We'll update the chart with the fetched data
                    // Note: In real app, might want separate charts or toggle buttons.
                    // Here we combine them for "System Overview".
                    
                    mainChart.data.labels = data.jamaah.labels;
                    mainChart.data.datasets = [
                        data.jamaah.datasets[0], // Jamaah
                        // Normalize Finance Data (Divide by 1000 or 1M) for visualization if scale differs too much
                        // For now, let's just show Jamaah data on this chart to be safe on scale
                        // Or we can use a second axis.
                    ];
                    
                    // Add Finance dataset if scale allows, or maybe separate chart is better.
                    // Let's stick to Jamaah trends for the main chart as per previous dashboard, 
                    // but enhanced.
                    
                    mainChart.update();
                })
                .catch(error => console.error('Error loading chart:', error));
        }

        // --- Real-time Stats Logic ---
        function refreshDashboard() {
            const icon = document.getElementById('refresh-icon');
            icon.classList.add('fa-spin');
            
            Promise.all([fetchRealTimeStats(), loadChartData()])
                .finally(() => {
                    setTimeout(() => icon.classList.remove('fa-spin'), 500);
                });
        }

        function fetchRealTimeStats() {
            return fetch(`{{ route('dashboard.stats') }}`)
                .then(response => response.json())
                .then(data => {
                    const stats = data.stats;
                    
                    // Animate Value Function
                    animateValue("stat-total-jamaah", parseInt(document.getElementById("stat-total-jamaah").innerText), stats.total_jamaah, 1000);
                    animateValue("stat-active-jamaah", parseInt(document.getElementById("stat-active-jamaah").innerText), stats.active_jamaah, 1000);
                    
                    // Format Currency
                    const formattedSaldo = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(stats.saldo_kas);
                    document.getElementById("stat-saldo").innerText = formattedSaldo.replace('Rp', 'Rp ');
                })
                .catch(error => console.error('Error fetching stats:', error));
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
                obj.innerHTML = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime > 0 ? stepTime : 10); // min 10ms
            
            // If range is huge, just set it immediately to avoid freezing
            if(Math.abs(range) > 100) {
                clearInterval(timer);
                obj.innerHTML = end;
            }
        }
    </script>
</x-app-layout>
