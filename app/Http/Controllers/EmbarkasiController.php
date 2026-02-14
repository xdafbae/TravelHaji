<?php

namespace App\Http\Controllers;

use App\Models\Embarkasi;
use App\Models\Pegawai;
use App\Models\Jamaah;
use App\Models\PriceList;
use App\Models\Stok;
use App\Models\BarangJamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\ManifestExport;
use Maatwebsite\Excel\Facades\Excel;

class EmbarkasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Embarkasi::with('tourLeader')->orderBy('waktu_keberangkatan', 'desc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_embarkasi', 'like', "%{$search}%")
                  ->orWhere('paket_haji_umroh', 'like', "%{$search}%")
                  ->orWhere('kota_keberangkatan', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $embarkasi = $query->paginate(10)->withQueryString();

        // Quick Stats
        $totalJadwal = Embarkasi::count();
        $totalJamaahTerdaftar = Embarkasi::sum('jumlah_jamaah');
        $jadwalBulanIni = Embarkasi::whereMonth('waktu_keberangkatan', now()->month)
                                    ->whereYear('waktu_keberangkatan', now()->year)
                                    ->count();

        return view('embarkasi.index', compact('embarkasi', 'totalJadwal', 'totalJamaahTerdaftar', 'jadwalBulanIni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tourLeaders = Pegawai::where('status', 'AKTIF')->get();
        $priceLists = PriceList::where('is_active', true)->orderBy('nama_item')->get();
        return view('embarkasi.create', compact('tourLeaders', 'priceLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'paket_haji_umroh' => 'required|string|max:255',
            'kota_keberangkatan' => 'required|string|max:255',
            'waktu_keberangkatan' => 'required|date',
            'waktu_kepulangan' => 'nullable|date|after:waktu_keberangkatan',
            'maskapai' => 'nullable|string|max:255',
            'pesawat_pergi' => 'nullable|string|max:255',
            'pesawat_pulang' => 'nullable|string|max:255',
            'kapasitas_jamaah' => 'required|integer|min:0',
            'harga_paket' => 'required|numeric|min:0',
            'id_tour_leader' => 'nullable|exists:pegawai,id_pegawai',
            'status' => 'required|in:Belum Berangkat,Sudah Berangkat,Selesai',
        ]);

        // Auto generate Code
        $lastItem = Embarkasi::latest('id_embarkasi')->first();
        if ($lastItem && preg_match('/EMB(\d+)/', $lastItem->kode_embarkasi, $matches)) {
            $newNumber = intval($matches[1]) + 1;
        } else {
            $newNumber = 1;
        }
        $kode = 'EMB' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        $validatedData['kode_embarkasi'] = $kode;
        $validatedData['jumlah_jamaah'] = 0; // Initial

        Embarkasi::create($validatedData);

        return redirect()->route('embarkasi.index')->with('success', 'Jadwal Keberangkatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $embarkasi = Embarkasi::with(['tourLeader', 'jamaah.passport', 'jamaah.barang'])->findOrFail($id);
        
        // Sync document status based on passport availability
        foreach ($embarkasi->jamaah as $jamaah) {
            $currentStatus = $jamaah->pivot->document_status;
            $newStatus = ($jamaah->passport && $jamaah->passport->no_passport) ? 'Lengkap' : 'Belum Lengkap';
            
            if ($currentStatus !== $newStatus) {
                $embarkasi->jamaah()->updateExistingPivot($jamaah->id_jamaah, [
                    'document_status' => $newStatus
                ]);
            }
        }
        
        // Reload to reflect changes
        $embarkasi->load('jamaah.passport');

        // Get Jamaah who are active and not yet departed (or assigned to this embarkasi)
        $availableJamaah = Jamaah::where('is_active', true)
            ->where('status_keberangkatan', 'Belum Berangkat')
            ->whereDoesntHave('embarkasi', function($q) use ($id) {
                $q->where('embarkasi.id_embarkasi', '!=', $id);
            })
            ->whereNotIn('id_jamaah', $embarkasi->jamaah->pluck('id_jamaah'))
            ->get();

        // Get Available Stock Items
        $stokItems = Stok::where('is_tersedia', true)->orderBy('nama_barang')->get();

        return view('embarkasi.show', compact('embarkasi', 'availableJamaah', 'stokItems'));
    }

    public function addJamaah(Request $request, string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        
        $validated = $request->validate([
            'jamaah_ids' => 'required|array',
            'jamaah_ids.*' => 'exists:jamaah,id_jamaah',
        ]);

        foreach ($validated['jamaah_ids'] as $jamaahId) {
            // Check capacity
            if ($embarkasi->jumlah_jamaah >= $embarkasi->kapasitas_jamaah) {
                return redirect()->back()->with('error', 'Kapasitas penuh! Beberapa jamaah mungkin tidak tertambahkan.');
            }

            // Check if already assigned to this embarkasi
            if (!$embarkasi->jamaah()->where('jamaah.id_jamaah', $jamaahId)->exists()) {
                $embarkasi->jamaah()->attach($jamaahId, [
                    'payment_status' => 'Pending',
                    'document_status' => 'Belum Lengkap'
                ]);
                
                $embarkasi->increment('jumlah_jamaah');
            }
        }

        return redirect()->route('embarkasi.show', $id)->with('success', 'Jamaah berhasil ditambahkan ke manifest.');
    }

    public function removeJamaah(string $id, string $jamaahId)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        
        if ($embarkasi->jamaah()->detach($jamaahId)) {
            $embarkasi->decrement('jumlah_jamaah');
        }

        return redirect()->route('embarkasi.show', $id)->with('success', 'Jamaah dihapus dari manifest.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        $newStatus = $request->input('status');

        if (in_array($newStatus, ['Belum Berangkat', 'Sudah Berangkat', 'Selesai'])) {
            $embarkasi->update(['status' => $newStatus]);

            // Sync Jamaah status
            if ($newStatus == 'Sudah Berangkat') {
                // Update all jamaah in this embarkasi
                $jamaahIds = $embarkasi->jamaah()->pluck('jamaah.id_jamaah');
                Jamaah::whereIn('id_jamaah', $jamaahIds)
                    ->update(['status_keberangkatan' => 'Sudah Berangkat']);
            }
        }

        return redirect()->route('embarkasi.show', $id)->with('success', 'Status keberangkatan diperbarui.');
    }

    public function uploadDocuments(Request $request, string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);

        $validated = $request->validate([
            'boarding_pass_file' => 'nullable|file|mimes:zip,pdf,jpg,png|max:10240', // 10MB
            'manifest_file' => 'nullable|file|mimes:pdf,xlsx,xls|max:5120', // 5MB
        ]);

        if ($request->hasFile('boarding_pass_file')) {
            if ($embarkasi->boarding_pass_file) {
                Storage::disk('public')->delete($embarkasi->boarding_pass_file);
            }
            $embarkasi->boarding_pass_file = $request->file('boarding_pass_file')->store('embarkasi/boarding_pass', 'public');
        }

        if ($request->hasFile('manifest_file')) {
            if ($embarkasi->manifest_file) {
                Storage::disk('public')->delete($embarkasi->manifest_file);
            }
            $embarkasi->manifest_file = $request->file('manifest_file')->store('embarkasi/manifest', 'public');
        }

        $embarkasi->save();

        return redirect()->route('embarkasi.show', $id)->with('success', 'Dokumen keberangkatan berhasil diupload.');
    }

    public function distributeItems(Request $request, string $id, string $jamaahId)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        $count = 0;
        foreach ($request->items as $stokId => $data) {
            if (isset($data['selected'])) {
                $qty = intval($data['qty']);
                if ($qty > 0) {
                    $stok = Stok::find($stokId);
                    
                    if ($stok && $stok->stok_tersedia >= $qty) {
                        // Reduce Stock
                        $stok->decrement('stok_tersedia', $qty);
                        $stok->increment('stok_keluar', $qty);

                        // Record Distribution
                        BarangJamaah::create([
                            'id_jamaah' => $jamaahId,
                            'deskripsi_barang' => $stok->nama_barang . ' (' . $stok->kode_barang . ')',
                            'jumlah' => $qty,
                            'status_penyerahan' => 'Sudah Diserahkan',
                            'tgl_penyerahan' => now(),
                            // 'diserahkan_oleh' => auth()->id(), // Uncomment if auth is ready
                        ]);
                        $count++;
                    }
                }
            }
        }

        if ($count > 0) {
            return redirect()->back()->with('success', $count . ' jenis barang berhasil didistribusikan ke jamaah.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada barang yang dipilih atau stok tidak mencukupi.');
    }

    public function exportManifest(string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        $fileName = 'Manifest_' . $embarkasi->kode_embarkasi . '_' . date('Ymd_His') . '.xlsx';
        
        return Excel::download(new ManifestExport($id), $fileName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        $tourLeaders = Pegawai::where('status', 'AKTIF')->get();
        $priceLists = PriceList::where('is_active', true)->orderBy('nama_item')->get();
        return view('embarkasi.edit', compact('embarkasi', 'tourLeaders', 'priceLists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);

        $validatedData = $request->validate([
            'paket_haji_umroh' => 'required|string|max:255',
            'kota_keberangkatan' => 'required|string|max:255',
            'waktu_keberangkatan' => 'required|date',
            'waktu_kepulangan' => 'nullable|date|after:waktu_keberangkatan',
            'maskapai' => 'nullable|string|max:255',
            'pesawat_pergi' => 'nullable|string|max:255',
            'pesawat_pulang' => 'nullable|string|max:255',
            'kapasitas_jamaah' => 'required|integer|min:0',
            'harga_paket' => 'required|numeric|min:0',
            'id_tour_leader' => 'nullable|exists:pegawai,id_pegawai',
            'status' => 'required|in:Belum Berangkat,Sudah Berangkat,Selesai',
        ]);

        $embarkasi->update($validatedData);

        return redirect()->route('embarkasi.index')->with('success', 'Jadwal Keberangkatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $embarkasi = Embarkasi::findOrFail($id);
        $embarkasi->delete();

        return redirect()->route('embarkasi.index')->with('success', 'Jadwal Keberangkatan berhasil dihapus.');
    }
}
