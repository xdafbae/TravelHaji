<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\KodeAkuntansi;
use App\Models\Jamaah;
use App\Models\Embarkasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));
        $type = $request->input('type'); // Debet or Kredit

        $query = Kas::with(['kodeAkuntansi', 'jamaah'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if ($type) {
            $query->where('jenis', $type);
        }

        $transactions = $query->paginate(15);

        // Calculate summary
        $totalDebet = Kas::whereBetween('tanggal', [$startDate, $endDate])->whereIn('jenis', ['Debet', 'DEBET'])->sum('jumlah');
        $totalKredit = Kas::whereBetween('tanggal', [$startDate, $endDate])->whereIn('jenis', ['Kredit', 'KREDIT'])->sum('jumlah');
        $balance = $totalDebet - $totalKredit;

        // Calculate running balance (saldo berjalan)
        // Saldo awal = (Debet - Kredit) sebelum start_date
        $prevDebet = Kas::where('tanggal', '<', $startDate)->whereIn('jenis', ['Debet', 'DEBET'])->sum('jumlah');
        $prevKredit = Kas::where('tanggal', '<', $startDate)->whereIn('jenis', ['Kredit', 'KREDIT'])->sum('jumlah');
        $openingBalance = $prevDebet - $prevKredit;

        return view('finance.index', compact(
            'transactions', 
            'startDate', 
            'endDate', 
            'totalDebet', 
            'totalKredit', 
            'balance',
            'openingBalance'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = KodeAkuntansi::where('is_active', true)->orderBy('kode')->get();
        $jamaah = Jamaah::where('is_active', true)->orderBy('nama_lengkap')->get();
        
        return view('finance.create', compact('accounts', 'jamaah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Debet,Kredit',
            'kode_akuntansi_id' => 'required|exists:kode_akuntansi,id',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'id_jamaah' => 'nullable|exists:jamaah,id_jamaah',
            'deskripsi' => 'nullable|string',
            'bukti_transaksi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('finance/proofs', 'public');
        }

        // Add current time if not present (although table structure requires it, we auto-fill it)
        $validated['waktu'] = now()->format('H:i:s');
        
        // Ensure jenis is Uppercase to match Enum
        $validated['jenis'] = strtoupper($validated['jenis']);

        Kas::create($validated);

        // --- Auto Update Payment Status Jamaah ---
        if ($request->filled('id_jamaah') && $validated['jenis'] === 'DEBET') {
            // Check if Account Code is Revenue (Starts with 4)
            $kodeAkun = KodeAkuntansi::find($validated['kode_akuntansi_id']);
            
            if ($kodeAkun && str_starts_with($kodeAkun->kode, '4')) {
                $jamaah = Jamaah::find($validated['id_jamaah']);
                
                if ($jamaah) {
                    // Get Active Embarkasi for this Jamaah
                    // Assuming payment is for the active/upcoming departure
                    $embarkasi = $jamaah->embarkasi()
                                        ->where('embarkasi.status', '!=', 'Selesai')
                                        ->orderBy('embarkasi.waktu_keberangkatan', 'asc')
                                        ->first();

                    if ($embarkasi) {
                        // Calculate Total Payment for this Jamaah (Revenue Accounts only)
                        $totalBayar = Kas::where('id_jamaah', $jamaah->id_jamaah)
                            ->where('jenis', 'DEBET')
                            ->whereHas('kodeAkuntansi', function($q) {
                                $q->where('kode', 'like', '4%');
                            })
                            ->sum('jumlah');

                        $hargaPaket = $embarkasi->harga_paket;

                        // Determine Status
                        $newStatus = ($totalBayar >= $hargaPaket) ? 'Lunas' : 'Belum Lunas';

                        // Update Pivot Table
                        $jamaah->embarkasi()->updateExistingPivot($embarkasi->id_embarkasi, [
                            'payment_status' => $newStatus
                        ]);
                    }
                }
            }
        }
        // -----------------------------------------

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kas = Kas::findOrFail($id);
        $accounts = KodeAkuntansi::where('is_active', true)->orderBy('kode')->get();
        $jamaah = Jamaah::where('is_active', true)->orderBy('nama_lengkap')->get();

        return view('finance.edit', compact('kas', 'accounts', 'jamaah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kas = Kas::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Debet,Kredit',
            'kode_akuntansi_id' => 'required|exists:kode_akuntansi,id',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'id_jamaah' => 'nullable|exists:jamaah,id_jamaah',
            'deskripsi' => 'nullable|string',
            'bukti_transaksi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            // Delete old file
            if ($kas->bukti_transaksi) {
                // Storage::disk('public')->delete($kas->bukti_transaksi); // Uncomment if Storage facade is imported
            }
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('finance/proofs', 'public');
        }

        // Ensure jenis is Uppercase to match Enum
        $validated['jenis'] = strtoupper($validated['jenis']);

        $kas->update($validated);

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kas = Kas::findOrFail($id);
        $kas->delete();

        return redirect()->route('finance.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        // Get Summary Grouped by Category & Account
        $reportData = DB::table('kas')
            ->join('kode_akuntansi', 'kas.kode_akuntansi_id', '=', 'kode_akuntansi.id')
            ->select(
                'kode_akuntansi.kategori',
                'kode_akuntansi.kode',
                'kode_akuntansi.keterangan as nama_akun',
                DB::raw('SUM(kas.jumlah) as total'),
                'kas.jenis'
            )
            ->whereBetween('kas.tanggal', [$startDate, $endDate])
            ->whereNull('kas.deleted_at')
            ->groupBy('kode_akuntansi.kategori', 'kode_akuntansi.kode', 'kode_akuntansi.keterangan', 'kas.jenis')
            ->orderBy('kode_akuntansi.kode')
            ->get();

        // Organize data for view
        $pemasukan = $reportData->filter(function ($item) {
            return strtoupper($item->jenis) === 'DEBET';
        });
        
        $pengeluaran = $reportData->filter(function ($item) {
            return strtoupper($item->jenis) === 'KREDIT';
        });

        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('total');
        $labaRugi = $totalPemasukan - $totalPengeluaran;

        return view('finance.report', compact(
            'startDate', 
            'endDate', 
            'pemasukan', 
            'pengeluaran', 
            'totalPemasukan', 
            'totalPengeluaran', 
            'labaRugi'
        ));
    }
}
