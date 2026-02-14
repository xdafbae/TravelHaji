<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('kontak', 'like', '%' . $search . '%');
            });
        }

        // Filter Category
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        // Filter Status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Sorting
        $sortField = $request->input('sort_by', 'nama_supplier');
        $sortOrder = $request->input('sort_order', 'asc');
        $allowedSorts = ['nama_supplier', 'kategori', 'email', 'is_active', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('nama_supplier', 'asc');
        }

        $suppliers = $query->paginate(10)->withQueryString();

        // KPI Data
        $totalSuppliers = Supplier::count();
        $activeSuppliers = Supplier::where('is_active', 1)->count();
        $inactiveSuppliers = Supplier::where('is_active', 0)->count();

        return view('supplier.index', compact('suppliers', 'totalSuppliers', 'activeSuppliers', 'inactiveSuppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
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
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle checkbox boolean
        $validated['is_active'] = $request->has('is_active');

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Data Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
