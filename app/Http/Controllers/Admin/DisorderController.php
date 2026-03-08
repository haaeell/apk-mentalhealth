<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentalDisorder;
use App\Models\Symptom;
use App\Models\DisorderSymptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisorderController extends Controller
{
    public function index()
    {
        $disorders = MentalDisorder::withCount('symptoms')->latest()->get();
        return view('admin.disorders.index', compact('disorders'));
    }

    public function create()
    {
        $symptoms = Symptom::where('is_active', true)->get();
        return view('admin.disorders.create', compact('symptoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required|unique:mental_disorders,code',
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'recommendation' => 'required|string',
            'severity'      => 'required|in:ringan,sedang,berat',
            'color_code'    => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'symptoms'      => 'nullable|array',
            'symptoms.*.id' => 'exists:symptoms,id',
            'symptoms.*.mb' => 'numeric|min:0|max:1',
            'symptoms.*.md' => 'numeric|min:0|max:1',
        ]);

        $data = $request->only(['code', 'name', 'description', 'recommendation', 'severity', 'color_code']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('disorders', 'public');
        }

        $disorder = MentalDisorder::create($data);

        if ($request->has('symptoms')) {
            foreach ($request->symptoms as $symptom) {
                if (!empty($symptom['id'])) {
                    DisorderSymptom::create([
                        'mental_disorder_id' => $disorder->id,
                        'symptom_id'         => $symptom['id'],
                        'mb'                 => $symptom['mb'],
                        'md'                 => $symptom['md'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.disorders.index')
            ->with('success', 'Gangguan mental berhasil ditambahkan!');
    }

    public function edit(MentalDisorder $disorder)
    {
        $symptoms = Symptom::where('is_active', true)->get();
        $disorderSymptoms = $disorder->disorderSymptoms()->with('symptom')->get();
        return view('admin.disorders.edit', compact('disorder', 'symptoms', 'disorderSymptoms'));
    }

    public function update(Request $request, MentalDisorder $disorder)
    {
        $request->validate([
            'code'          => 'required|unique:mental_disorders,code,' . $disorder->id,
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'recommendation' => 'required|string',
            'severity'      => 'required|in:ringan,sedang,berat',
            'color_code'    => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'symptoms'      => 'nullable|array',
            'symptoms.*.id' => 'exists:symptoms,id',
            'symptoms.*.mb' => 'numeric|min:0|max:1',
            'symptoms.*.md' => 'numeric|min:0|max:1',
        ]);

        $data = $request->only(['code', 'name', 'description', 'recommendation', 'severity', 'color_code', 'is_active']);

        // Handle hapus foto
        if ($request->boolean('remove_image') && $disorder->image) {
            Storage::disk('public')->delete($disorder->image);
            $data['image'] = null;
        }

        // Handle upload foto baru
        if ($request->hasFile('image')) {
            if ($disorder->image) {
                Storage::disk('public')->delete($disorder->image);
            }
            $data['image'] = $request->file('image')->store('disorders', 'public');
        }

        $disorder->update($data);

        // Update symptoms
        $disorder->disorderSymptoms()->delete();
        if ($request->has('symptoms')) {
            foreach ($request->symptoms as $symptom) {
                if (!empty($symptom['id'])) {
                    DisorderSymptom::create([
                        'mental_disorder_id' => $disorder->id,
                        'symptom_id'         => $symptom['id'],
                        'mb'                 => $symptom['mb'],
                        'md'                 => $symptom['md'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.disorders.index')
            ->with('success', 'Gangguan mental berhasil diperbarui!');
    }

    public function destroy(MentalDisorder $disorder)
    {
        if ($disorder->image) {
            Storage::disk('public')->delete($disorder->image);
        }
        $disorder->delete();
        return redirect()->route('admin.disorders.index')
            ->with('success', 'Gangguan mental berhasil dihapus!');
    }
}
