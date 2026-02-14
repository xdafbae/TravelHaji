<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pegawai::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Jabatan (Exact match if provided via filter dropdown)
        if ($request->filled('filter_jabatan')) {
            $query->where('jabatan', $request->filter_jabatan);
        }

        // Filter Wilayah
        if ($request->filled('filter_wilayah')) {
            $query->where('wilayah', $request->filter_wilayah);
        }

        // Sorting
        $sortField = $request->input('sort_by', 'nama_pegawai');
        $sortOrder = $request->input('sort_order', 'asc');
        $allowedSorts = ['nama_pegawai', 'username', 'jabatan', 'status', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('nama_pegawai', 'asc');
        }

        $pegawai = $query->paginate(10)->withQueryString();
        
        // Get unique Jabatan & Wilayah for filter dropdowns
        $jabatans = Pegawai::select('jabatan')->distinct()->whereNotNull('jabatan')->orderBy('jabatan')->pluck('jabatan');
        $wilayahs = Pegawai::select('wilayah')->distinct()->whereNotNull('wilayah')->orderBy('wilayah')->pluck('wilayah');

        return view('pegawai.index', compact('pegawai', 'jabatans', 'wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pegawai,username',
            'password' => 'required|string|min:6',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:AKTIF,TIDAK AKTIF',
            'tim_syiar' => 'nullable|string|max:100',
            'wilayah' => 'nullable|string|max:100',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
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
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:50', Rule::unique('pegawai')->ignore($id, 'id_pegawai')],
            'password' => 'nullable|string|min:6',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:AKTIF,TIDAK AKTIF',
            'tim_syiar' => 'nullable|string|max:100',
            'wilayah' => 'nullable|string|max:100',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        // Prevent deleting self if logged in as this employee (if auth logic uses this table)
        // For now just basic delete
        
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
