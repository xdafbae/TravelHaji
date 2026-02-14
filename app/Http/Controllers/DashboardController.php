<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Embarkasi;
use App\Models\Kas;
use App\Models\Passport;
use App\Models\Transaksi; // Assuming Transaksi exists or we use Kas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Initial data load for SEO/First Paint
        $stats = $this->gatherStats();
        $upcomingDeparture = Embarkasi::where('status', '!=', 'Selesai')
                                      ->orderBy('waktu_keberangkatan', 'asc')
                                      ->first();
        
        $recentActivities = $this->fetchRecentActivities();

        return view('dashboard', compact('stats', 'upcomingDeparture', 'recentActivities'));
    }

    /**
     * Get real-time stats via AJAX.
     */
    public function getStats()
    {
        return response()->json([
            'stats' => $this->gatherStats()
        ]);
    }

    /**
     * Get chart data for the dashboard.
     */
    public function getChartData(Request $request)
    {
        $range = $request->input('range', 'month'); // month, year
        
        // Jamaah Registration Chart
        $jamaahData = $this->getJamaahRegistrationData($range);
        
        // Financial Flow Chart
        $financeData = $this->getFinancialFlowData($range);

        return response()->json([
            'jamaah' => $jamaahData,
            'finance' => $financeData
        ]);
    }

    private function gatherStats()
    {
        $totalJamaah = Jamaah::count();
        $activeJamaah = Jamaah::where('status_keberangkatan', 'Belum Berangkat')->count(); // Adjust column name if needed
        
        // Kas Summary
        $kasMasuk = Kas::where('jenis', 'DEBET')->orWhere('jenis', 'Debet')->sum('jumlah');
        $kasKeluar = Kas::where('jenis', 'KREDIT')->orWhere('jenis', 'Kredit')->sum('jumlah');
        $saldo = $kasMasuk - $kasKeluar;

        // Passport Pending
        $passportPending = Passport::where('status_visa', 'Pending')->count();

        return [
            'total_jamaah' => $totalJamaah,
            'active_jamaah' => $activeJamaah,
            'saldo_kas' => $saldo,
            'passport_pending' => $passportPending,
            'kas_masuk_month' => Kas::whereIn('jenis', ['DEBET', 'Debet'])->whereMonth('tanggal', now()->month)->sum('jumlah'),
            'kas_keluar_month' => Kas::whereIn('jenis', ['KREDIT', 'Kredit'])->whereMonth('tanggal', now()->month)->sum('jumlah'),
        ];
    }

    private function fetchRecentActivities()
    {
        // Combine recent updates from multiple models
        // For simplicity, let's just get recent Kas transactions and New Jamaah
        
        $activities = collect();

        // Recent Jamaah
        $newJamaah = Jamaah::latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'jamaah',
                'title' => 'Jamaah Baru',
                'description' => $item->nama_lengkap . ' mendaftar.',
                'time' => $item->created_at->diffForHumans(),
                'timestamp' => $item->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'emerald'
            ];
        });

        // Recent Finance
        $newKas = Kas::latest('tanggal')->take(5)->get()->map(function($item) {
            $type = strtoupper($item->jenis) == 'DEBET' ? 'Pemasukan' : 'Pengeluaran';
            $color = strtoupper($item->jenis) == 'DEBET' ? 'blue' : 'red';
            $icon = strtoupper($item->jenis) == 'DEBET' ? 'fas fa-arrow-down' : 'fas fa-arrow-up';
            
            return [
                'type' => 'finance',
                'title' => 'Transaksi ' . $type,
                'description' => $item->keterangan . ' (Rp ' . number_format($item->jumlah, 0, ',', '.') . ')',
                'time' => \Carbon\Carbon::parse($item->tanggal)->diffForHumans(),
                'timestamp' => $item->created_at, // Assuming created_at exists, else use tanggal
                'icon' => $icon,
                'color' => $color
            ];
        });

        return $activities->concat($newJamaah)->concat($newKas)->sortByDesc('timestamp')->take(10)->values();
    }

    private function getJamaahRegistrationData($range)
    {
        // Default to monthly data for current year
        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->format('M');
            $labels[] = $monthName;
            $data[] = Jamaah::whereYear('created_at', date('Y'))
                            ->whereMonth('created_at', $i)
                            ->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendaftaran Jamaah ' . date('Y'),
                    'data' => $data,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }

    private function getFinancialFlowData($range)
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            
            $incomeData[] = Kas::whereYear('tanggal', date('Y'))
                               ->whereMonth('tanggal', $i)
                               ->whereIn('jenis', ['DEBET', 'Debet'])
                               ->sum('jumlah');
            
            $expenseData[] = Kas::whereYear('tanggal', date('Y'))
                                ->whereMonth('tanggal', $i)
                                ->whereIn('jenis', ['KREDIT', 'Kredit'])
                                ->sum('jumlah');
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $incomeData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expenseData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }
}
