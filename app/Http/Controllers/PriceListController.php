<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceLists = PriceList::orderBy('created_at', 'desc')->paginate(10);
        return view('price_list.index', compact('priceLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('price_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kode_item' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'form_a' => 'boolean',
            'form_b' => 'boolean',
            'form_c' => 'boolean',
            'form_d' => 'boolean',
            'form_d_barang' => 'boolean',
            'form_d_jasa' => 'boolean',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Auto generate Code if empty
        if (empty($validatedData['kode_item'])) {
            $lastItem = PriceList::latest('id_pricelist')->first();
            $newId = $lastItem ? $lastItem->id_pricelist + 1 : 1;
            $validatedData['kode_item'] = 'ITM' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        }

        // Set defaults for checkboxes if not present (though validation handles boolean)
        $validatedData['form_a'] = $request->has('form_a');
        $validatedData['form_b'] = $request->has('form_b');
        $validatedData['form_c'] = $request->has('form_c');
        $validatedData['form_d'] = $request->has('form_d');
        $validatedData['form_d_barang'] = $request->has('form_d_barang');
        $validatedData['form_d_jasa'] = $request->has('form_d_jasa');
        $validatedData['is_active'] = true;

        PriceList::create($validatedData);

        return redirect()->route('price-list.index')->with('success', 'Item berhasil ditambahkan ke Price List.');
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
        $priceList = PriceList::findOrFail($id);
        return view('price_list.edit', compact('priceList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $priceList = PriceList::findOrFail($id);

        $validatedData = $request->validate([
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kode_item' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'form_a' => 'boolean',
            'form_b' => 'boolean',
            'form_c' => 'boolean',
            'form_d' => 'boolean',
            'form_d_barang' => 'boolean',
            'form_d_jasa' => 'boolean',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        // Handle checkboxes
        $validatedData['form_a'] = $request->has('form_a');
        $validatedData['form_b'] = $request->has('form_b');
        $validatedData['form_c'] = $request->has('form_c');
        $validatedData['form_d'] = $request->has('form_d');
        $validatedData['form_d_barang'] = $request->has('form_d_barang');
        $validatedData['form_d_jasa'] = $request->has('form_d_jasa');
        $validatedData['is_active'] = $request->has('is_active');

        $priceList->update($validatedData);

        return redirect()->route('price-list.index')->with('success', 'Item Price List berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priceList = PriceList::findOrFail($id);
        $priceList->delete();

        return redirect()->route('price-list.index')->with('success', 'Item Price List berhasil dihapus.');
    }
}
