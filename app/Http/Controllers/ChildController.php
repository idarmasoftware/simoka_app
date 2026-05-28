<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->isOrangTua()) {
            $children = Child::with(['parent', 'therapis'])->where('parent_id', $currentUser->id)->latest()->paginate(10);
        } elseif ($currentUser->isTerapis()) {
            $children = Child::with(['parent', 'therapis'])->where('therapis_id', $currentUser->id)->latest()->paginate(10);
        } else {
            $children = Child::with(['parent', 'therapis'])->latest()->paginate(10);
        }

        return view('children.index', compact('children'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = User::where('role', 'orang_tua')->get();
        $therapists = User::where('role', 'terapis')->get();

        return view('children.create', compact('parents', 'therapists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'catatan_medis' => 'nullable|string',
        ];

        if ($currentUser->isOrangTua()) {
            $rules['therapis_id'] = 'nullable|exists:users,id';
            $rules['parent_id'] = 'nullable';
        } else {
            $rules['parent_id'] = 'required|exists:users,id';
            $rules['therapis_id'] = 'nullable|exists:users,id';
        }

        $validated = $request->validate($rules);

        if ($currentUser->isOrangTua()) {
            $validated['parent_id'] = $currentUser->id;
        }

        Child::create($validated);

        return redirect()->route('children.index')->with('success', 'Data anak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Child $child)
    {
        return redirect()->route('children.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Child $child)
    {
        $currentUser = Auth::user();

        if ($currentUser->isOrangTua() && $child->parent_id !== $currentUser->id) {
            abort(403, 'Anda tidak diizinkan mengubah data anak ini.');
        }

        if ($currentUser->isTerapis() && $child->therapis_id !== $currentUser->id) {
            abort(403, 'Anda tidak diizinkan mengubah data anak ini.');
        }

        $parents = User::where('role', 'orang_tua')->get();
        $therapists = User::where('role', 'terapis')->get();

        return view('children.edit', compact('child', 'parents', 'therapists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Child $child)
    {
        $currentUser = Auth::user();

        if ($currentUser->isOrangTua() && $child->parent_id !== $currentUser->id) {
            abort(403, 'Anda tidak diizinkan mengubah data anak ini.');
        }

        if ($currentUser->isTerapis() && $child->therapis_id !== $currentUser->id) {
            abort(403, 'Anda tidak diizinkan mengubah data anak ini.');
        }

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'catatan_medis' => 'nullable|string',
            'is_active' => 'nullable',
        ];

        if ($currentUser->isOrangTua()) {
            $rules['therapis_id'] = 'nullable|exists:users,id';
            $rules['parent_id'] = 'nullable';
        } else {
            $rules['parent_id'] = 'required|exists:users,id';
            $rules['therapis_id'] = 'nullable|exists:users,id';
        }

        $validated = $request->validate($rules);

        if ($currentUser->isOrangTua()) {
            $validated['parent_id'] = $currentUser->id;
        }

        $validated['is_active'] = $request->has('is_active');

        $child->update($validated);

        return redirect()->route('children.index')->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Child $child)
    {
        $currentUser = Auth::user();

        if (! $currentUser->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang diizinkan menghapus data anak.');
        }

        $child->delete();

        return redirect()->route('children.index')->with('success', 'Data anak berhasil dihapus.');
    }
}
