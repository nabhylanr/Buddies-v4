<?php

namespace App\Http\Controllers;

use App\Models\Recap;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        $query = Recap::query();

        if ($request->filled('company_id')) {
            $query->where('company_id', 'like', '%' . $request->company_id . '%');
        }

        if ($request->filled('nama_perusahaan')) {
            $query->where('nama_perusahaan', 'like', '%' . $request->nama_perusahaan . '%');
        }

        if ($request->filled('cabang')) {
            $query->where('cabang', $request->cabang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $recaps = $query->latest()->paginate(10);
        $cabangList = Recap::select('cabang')->distinct()->pluck('cabang');
        $statusList = Recap::select('status')->distinct()->pluck('status');

        return view('recaps.index', [
            'recaps' => $recaps,
            'cabangList' => $cabangList,
            'statusList' => $statusList,
        ]);
    }

    public function create()
    {
        return view('recaps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'nullable|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'cabang' => 'nullable|string|max:255',
            'sales' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        Recap::create([
            'company_id' => $request->company_id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'cabang' => $request->cabang,
            'sales' => $request->sales,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('recaps.index')
            ->with('success', 'Recap berhasil ditambahkan!');
    }

    public function show(Recap $recap)
    {
        return view('recaps.show', compact('recap'));
    }

    public function edit(Recap $recap)
    {
        return view('recaps.edit', compact('recap'));
    }

    public function update(Request $request, Recap $recap)
    {
        $request->validate([
            'company_id' => 'nullable|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'cabang' => 'nullable|string|max:255',
            'sales' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $recap->update($request->all());

        return redirect()->route('recaps.index')
            ->with('success', 'Recap berhasil diupdate!');
    }

    public function destroy(Recap $recap)
    {
        $recap->delete();

        return redirect()->route('recaps.index')
            ->with('success', 'Recap berhasil dihapus!');
    }

    public function view(Request $request)
    {
        $query = Recap::query();

        if ($request->filled('company_id')) {
            $query->where('company_id', 'like', '%' . $request->company_id . '%');
        }

        if ($request->filled('nama_perusahaan')) {
            $query->where('nama_perusahaan', 'like', '%' . $request->nama_perusahaan . '%');
        }

        if ($request->filled('cabang')) {
            $query->where('cabang', $request->cabang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $recaps = $query->latest()->paginate(10);
        $cabangList = Recap::select('cabang')->distinct()->pluck('cabang');
        $statusList = Recap::select('status')->distinct()->pluck('status');

        return view('recaps.user', [
            'recaps' => $recaps,
            'cabangList' => $cabangList,
            'statusList' => $statusList,
        ]);
    }

    
}
