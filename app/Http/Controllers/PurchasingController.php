<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier')->orderBy('created_at', 'desc')->paginate(10);
        return view('purchasing.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->orderBy('nama_supplier')->get();
        return view('purchasing.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'waktu_preorder' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Generate Code
        $lastPO = Purchase::latest('id_purchase')->first();
        if ($lastPO && preg_match('/PO-(\d+)/', $lastPO->kode_purchase, $matches)) {
            $newNumber = intval($matches[1]) + 1;
        } else {
            $newNumber = 1;
        }
        $code = 'PO-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        $purchase = Purchase::create([
            'kode_purchase' => $code,
            'id_supplier' => $validated['id_supplier'],
            'waktu_preorder' => $validated['waktu_preorder'],
            'keterangan' => $validated['keterangan'],
            'status' => 'Data Masih Kosong',
            'total_amount' => 0
        ]);

        return redirect()->route('purchasing.show', $purchase->id_purchase)->with('success', 'Purchase Order berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['supplier', 'details.stok'])->findOrFail($id);
        $items = Stok::where('is_tersedia', true)->orderBy('nama_barang')->get();
        
        return view('purchasing.show', compact('purchase', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $suppliers = Supplier::where('is_active', true)->orderBy('nama_supplier')->get();
        return view('purchasing.edit', compact('purchase', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);
        
        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'waktu_preorder' => 'required|date',
            'tgl_barang_datang' => 'nullable|date',
            'status' => 'required|in:Data Masih Kosong,Ada Data,Lunas',
            'keterangan' => 'nullable|string',
        ]);

        // Check for status change
        $oldStatus = $purchase->status;
        $newStatus = $validated['status'];

        DB::transaction(function () use ($purchase, $validated, $oldStatus, $newStatus) {
            $purchase->update($validated);

            // If status changed to Lunas, increment stock
            if ($oldStatus != 'Lunas' && $newStatus == 'Lunas') {
                $details = $purchase->details; // Get all items
                foreach ($details as $detail) {
                    // Update Stock
                    $stok = Stok::find($detail->id_stok);
                    if ($stok) {
                        $stok->increment('stok_tersedia', $detail->qty);
                    }
                }
            }
        });

        return redirect()->route('purchasing.show', $id)->with('success', 'Purchase Order berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        return redirect()->route('purchasing.index')->with('success', 'Purchase Order berhasil dihapus.');
    }

    // Add Item to PO
    public function addItem(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);
        
        $validated = $request->validate([
            'id_stok' => 'required|exists:stok,id_stok',
            'qty' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $subtotal = $validated['qty'] * $validated['harga_satuan'];

        PurchaseDetail::create([
            'id_purchase' => $id,
            'id_stok' => $validated['id_stok'],
            'qty' => $validated['qty'],
            'harga_satuan' => $validated['harga_satuan'],
            'subtotal' => $subtotal,
            'total_bayar' => $subtotal // Simplified for now
        ]);

        // Update Total PO
        $this->recalculateTotal($id);
        
        // Update Status if first item
        if ($purchase->status == 'Data Masih Kosong') {
            $purchase->update(['status' => 'Ada Data']);
        }

        return redirect()->back()->with('success', 'Item berhasil ditambahkan.');
    }

    // Remove Item from PO
    public function removeItem(string $id, string $detailId)
    {
        $detail = PurchaseDetail::where('id_purchase', $id)->where('id', $detailId)->firstOrFail();
        $detail->delete();

        $this->recalculateTotal($id);

        return redirect()->back()->with('success', 'Item dihapus dari PO.');
    }

    private function recalculateTotal($purchaseId)
    {
        $total = PurchaseDetail::where('id_purchase', $purchaseId)->sum('subtotal');
        Purchase::where('id_purchase', $purchaseId)->update(['total_amount' => $total]);
    }
}
