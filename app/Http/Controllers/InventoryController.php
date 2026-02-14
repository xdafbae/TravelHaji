<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stok::query();

        // Search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%')
                  ->orWhere('inisial_barang', 'like', '%' . $search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_tersedia', $status);
        }

        // Filter Low Stock
        if ($request->filled('low_stock') && $request->low_stock == '1') {
            $query->whereColumn('stok_tersedia', '<=', 'buffer_stok');
        }

        // Sorting
        $sortField = $request->input('sort_by', 'nama_barang');
        $sortOrder = $request->input('sort_order', 'asc');
        $allowedSorts = ['nama_barang', 'kode_barang', 'stok_tersedia', 'buffer_stok', 'is_tersedia'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('nama_barang', 'asc');
        }

        $items = $query->paginate(10)->withQueryString();

        // KPI Data
        $totalItems = Stok::count();
        $lowStockItems = Stok::whereColumn('stok_tersedia', '<=', 'buffer_stok')->count();
        $activeItems = Stok::where('is_tersedia', 1)->count();
        $inactiveItems = Stok::where('is_tersedia', 0)->count();

        return view('inventory.index', compact('items', 'totalItems', 'lowStockItems', 'activeItems', 'inactiveItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|unique:stok,kode_barang|max:50',
            'inisial_barang' => 'nullable|string|max:10',
            'buffer_stok' => 'required|integer|min:0',
            'stok_awal' => 'required|integer|min:0',
            'is_tersedia' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);
        
        // Initial stock available calculation (Assuming no movement yet)
        $validated['stok_tersedia'] = $validated['stok_awal'];
        $validated['stok_keluar'] = 0;

        Stok::create($validated);

        return redirect()->route('inventory.index')->with('success', 'Data Barang berhasil ditambahkan.');
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
        $item = Stok::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Stok::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:stok,kode_barang,' . $id . ',id_stok',
            'inisial_barang' => 'nullable|string|max:10',
            'buffer_stok' => 'required|integer|min:0',
            'is_tersedia' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);

        // Handle checkbox boolean
        $validated['is_tersedia'] = $request->has('is_tersedia');

        $item->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Data Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Stok::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus.');
    }
}
