<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PassportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $passports = Passport::with('jamaah')->latest()->paginate(10);
        return view('passport.index', compact('passports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Option to pre-select jamaah from query param
        $selectedJamaahId = $request->query('jamaah_id');
        
        // Only show jamaah who don't have passport yet
        $jamaah = Jamaah::whereDoesntHave('passport')
                        ->when($selectedJamaahId, function($q) use ($selectedJamaahId) {
                            return $q->orWhere('id_jamaah', $selectedJamaahId);
                        })
                        ->orderBy('nama_lengkap')
                        ->get();
                        
        return view('passport.create', compact('jamaah', 'selectedJamaahId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_jamaah' => 'required|exists:jamaah,id_jamaah|unique:passport,id_jamaah',
            'no_passport' => 'required|string|unique:passport,no_passport',
            'nama_passport' => 'required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_city' => 'required|string',
            'date_issued' => 'required|date',
            'date_expire' => 'required|date|after:date_issued',
            'issuing_office' => 'required|string',
            'scan_passport' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('scan_passport')) {
            $validatedData['scan_passport'] = $request->file('scan_passport')->store('passports', 'public');
        }
        
        $validatedData['status_visa'] = 'Pending';

        Passport::create($validatedData);

        return redirect()->route('passport.index')->with('success', 'Data Passport berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $passport = Passport::with('jamaah')->findOrFail($id);
        return view('passport.show', compact('passport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $passport = Passport::findOrFail($id);
        $jamaah = Jamaah::where('id_jamaah', $passport->id_jamaah)->get(); // Only current jamaah
        return view('passport.edit', compact('passport', 'jamaah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $passport = Passport::findOrFail($id);

        $validatedData = $request->validate([
            'no_passport' => 'required|string|unique:passport,no_passport,' . $id . ',id_passport',
            'nama_passport' => 'required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_city' => 'required|string',
            'date_issued' => 'required|date',
            'date_expire' => 'required|date|after:date_issued',
            'issuing_office' => 'required|string',
            'scan_passport' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'status_visa' => 'required|in:Pending,Approved,Issued,Rejected',
        ]);

        if ($request->hasFile('scan_passport')) {
            if ($passport->scan_passport) {
                Storage::disk('public')->delete($passport->scan_passport);
            }
            $validatedData['scan_passport'] = $request->file('scan_passport')->store('passports', 'public');
        }

        $passport->update($validatedData);

        return redirect()->route('passport.index')->with('success', 'Data Passport berhasil diperbarui.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $passport = Passport::findOrFail($id);
        
        $validated = $request->validate([
            'status_visa' => 'required|in:Pending,Approved,Issued,Rejected'
        ]);

        $passport->update(['status_visa' => $validated['status_visa']]);

        return back()->with('success', 'Status Visa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $passport = Passport::findOrFail($id);
        
        if ($passport->scan_passport) {
            Storage::disk('public')->delete($passport->scan_passport);
        }
        
        $passport->delete();

        return redirect()->route('passport.index')->with('success', 'Data Passport berhasil dihapus.');
    }
}
