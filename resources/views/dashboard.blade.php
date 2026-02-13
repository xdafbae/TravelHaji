<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-4">
        <!-- Total Jamaah -->
        <div class="p-6 bg-white rounded-lg shadow-sm border-l-4 border-emerald-500">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-100 rounded-full">
                    <i class="fas fa-users text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Jamaah</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $totalJamaah }}</p>
                </div>
            </div>
        </div>

        <!-- Active Jamaah -->
        <div class="p-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-user-clock text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Belum Berangkat</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $activeJamaah }}</p>
                </div>
            </div>
        </div>

        <!-- Saldo Kas -->
        <div class="p-6 bg-white rounded-lg shadow-sm border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-wallet text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Saldo Kas</p>
                    <p class="text-lg font-semibold text-gray-700">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Next Departure -->
        <div class="p-6 bg-white rounded-lg shadow-sm border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-plane-departure text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Keberangkatan Berikutnya</p>
                    <p class="text-sm font-semibold text-gray-700">
                        {{ $upcomingDeparture ? $upcomingDeparture->waktu_keberangkatan->format('d M Y') : 'Belum ada jadwal' }}
                    </p>
                    @if($upcomingDeparture)
                        <span class="text-xs text-gray-500">{{ $upcomingDeparture->kota_keberangkatan }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Chart Section -->
        <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-700">Statistik Pendaftaran Jamaah (Bulan Ini)</h3>
            <canvas id="jamaahChart"></canvas>
        </div>

        <!-- Recent Activity / Quick Actions -->
        <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-700">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="flex flex-col items-center justify-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-emerald-50 hover:border-emerald-200">
                    <i class="fas fa-user-plus text-emerald-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-600">Tambah Jamaah</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200">
                    <i class="fas fa-money-bill-wave text-blue-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-600">Input Kas</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200">
                    <i class="fas fa-calendar-plus text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-600">Jadwal Baru</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-200">
                    <i class="fas fa-file-invoice text-yellow-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-600">Laporan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('jamaahChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Jamaah Baru',
                        data: [12, 19, 3, 5, 2, 3], // Dummy data
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
