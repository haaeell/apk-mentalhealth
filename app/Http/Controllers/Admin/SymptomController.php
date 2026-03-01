<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::withCount('disorders')->latest()->paginate(15);
        return view('admin.symptoms.index', compact('symptoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:symptoms,code',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'question' => 'required|string',
            'category' => 'required|in:umum,emosi,perilaku,fisik,kognitif',
        ]);

        Symptom::create($request->all());
        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Gejala berhasil ditambahkan!');
    }

    public function update(Request $request, Symptom $symptom)
    {
        $request->validate([
            'code' => 'required|unique:symptoms,code,' . $symptom->id,
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'question' => 'required|string',
            'category' => 'required|in:umum,emosi,perilaku,fisik,kognitif',
        ]);

        $symptom->update($request->all());
        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Gejala berhasil diperbarui!');
    }

    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return redirect()->route('admin.symptoms.index')
            ->with('success', 'Gejala berhasil dihapus!');
    }
}
