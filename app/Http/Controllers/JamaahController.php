<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\JamaahExport;
use Maatwebsite\Excel\Facades\Excel;

class JamaahController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $stats = [
            'total' => Jamaah::count(),
            'sudah_berangkat' => Jamaah::where('status_keberangkatan', 'Sudah Berangkat')->count(),
            'belum_berangkat' => Jamaah::where('status_keberangkatan', 'Belum Berangkat')->count(),
        ];

        // Query with filters
        $query = Jamaah::with(['embarkasi' => function($q) {
            $q->orderBy('waktu_keberangkatan', 'desc');
        }])
        ->withSum(['kas as total_bayar' => function($q) {
            $q->where('jenis', 'DEBET')
              ->whereHas('kodeAkuntansi', function($ka) {
                  $ka->where('kode', 'like', '4%');
              });
        }], 'jumlah');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('kode_jamaah', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status_keberangkatan', $request->status);
        }

        $jamaah = $query->latest()->paginate(10);
        
        return view('jamaah.index', compact('jamaah', 'stats'));
    }

    public function export(Request $request)
    {
        return Excel::download(new JamaahExport($request), 'data_jamaah_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function create()
    {
        return view('jamaah.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:jamaah,nik|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kabupaten' => 'nullable|string|max:100',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'foto_diri' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'bank_pembayaran' => 'nullable|string|max:100',
            'nama_agen' => 'nullable|string|max:100',
        ]);

        // Auto-generate Kode Jamaah (J001, J002, etc.)
        $lastJamaah = Jamaah::latest('id_jamaah')->first();
        if ($lastJamaah) {
            $lastNumber = intval(substr($lastJamaah->kode_jamaah, 1));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $kodeJamaah = 'J' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $validatedData['kode_jamaah'] = $kodeJamaah;
        $validatedData['status_keberangkatan'] = 'Belum Berangkat';
        $validatedData['is_active'] = true;

        // Handle File Uploads
        if ($request->hasFile('foto_ktp')) {
            $validatedData['foto_ktp'] = $request->file('foto_ktp')->store('jamaah/ktp', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            $validatedData['foto_kk'] = $request->file('foto_kk')->store('jamaah/kk', 'public');
        }
        if ($request->hasFile('foto_diri')) {
            $validatedData['foto_diri'] = $request->file('foto_diri')->store('jamaah/foto', 'public');
        }

        Jamaah::create($validatedData);

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil disimpan.');
    }

    public function show(Jamaah $jamaah)
    {
        $jamaah->load(['embarkasi', 'kas', 'transaksi']);
        return view('jamaah.show', compact('jamaah'));
    }

    public function edit(Jamaah $jamaah)
    {
        return view('jamaah.edit', compact('jamaah'));
    }

    public function update(Request $request, Jamaah $jamaah)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:jamaah,nik,' . $jamaah->id_jamaah . ',id_jamaah',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kabupaten' => 'nullable|string|max:100',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'foto_diri' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'bank_pembayaran' => 'nullable|string|max:100',
            'nama_agen' => 'nullable|string|max:100',
        ]);

        // Handle File Uploads
        if ($request->hasFile('foto_ktp')) {
            if ($jamaah->foto_ktp) Storage::disk('public')->delete($jamaah->foto_ktp);
            $validatedData['foto_ktp'] = $request->file('foto_ktp')->store('jamaah/ktp', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            if ($jamaah->foto_kk) Storage::disk('public')->delete($jamaah->foto_kk);
            $validatedData['foto_kk'] = $request->file('foto_kk')->store('jamaah/kk', 'public');
        }
        if ($request->hasFile('foto_diri')) {
            if ($jamaah->foto_diri) Storage::disk('public')->delete($jamaah->foto_diri);
            $validatedData['foto_diri'] = $request->file('foto_diri')->store('jamaah/foto', 'public');
        }

        $jamaah->update($validatedData);

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil diperbarui.');
    }

    public function destroy(Jamaah $jamaah)
    {
        if ($jamaah->foto_ktp) Storage::disk('public')->delete($jamaah->foto_ktp);
        if ($jamaah->foto_kk) Storage::disk('public')->delete($jamaah->foto_kk);
        if ($jamaah->foto_diri) Storage::disk('public')->delete($jamaah->foto_diri);
        
        $jamaah->delete();

        return redirect()->route('jamaah.index')->with('success', 'Data Jamaah berhasil dihapus.');
    }
}
