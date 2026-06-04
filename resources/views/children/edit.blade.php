@extends('layouts.app')

@section('title', 'Ubah Data Pasien - SI-MOKA')
@section('page_title', 'Ubah Data Pasien')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('children.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-100 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Ubah Data Pasien (Anak)</h2>
            <p class="text-slate-500 text-sm">Perbarui data anak, orang tua, dan terapis.</p>
        </div>
    </div>

    <form action="{{ route('children.update', $child) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">
            <!-- Nama Lengkap Anak -->
            <div class="space-y-2">
                <label for="nama_lengkap" class="text-sm font-bold text-slate-700">Nama Lengkap Pasien (Anak)</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $child->nama_lengkap) }}"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                       placeholder="Masukkan nama lengkap anak" required>
                @error('nama_lengkap') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Lahir -->
                <div class="space-y-2">
                    <label for="tanggal_lahir" class="text-sm font-bold text-slate-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $child->tanggal_lahir ? $child->tanggal_lahir->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           required>
                    @error('tanggal_lahir') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 block">Jenis Kelamin</label>
                    <div class="flex items-center gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" {{ old('jenis_kelamin', $child->jenis_kelamin) == 'L' ? 'checked' : '' }} required>
                            <span class="text-sm text-slate-600 font-medium">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-pink-600 border-slate-300 focus:ring-pink-500" {{ old('jenis_kelamin', $child->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                            <span class="text-sm text-slate-600 font-medium">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="h-px bg-slate-100 my-4"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Orang Tua -->
                @if(auth()->user()->isOrangTua())
                    <input type="hidden" name="parent_id" value="{{ $child->parent_id }}">
                @else
                    <div class="space-y-2">
                        <label for="parent_id" class="text-sm font-bold text-slate-700">Orang Tua</label>
                        <select name="parent_id" id="parent_id"
                                class="w-full" required>
                            <option value="" disabled>Pilih Orang Tua</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $child->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} ({{ $parent->phone_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <!-- Terapis -->
                <div class="space-y-2">
                    <label for="therapis_id" class="text-sm font-bold text-slate-700">Terapis Penanggung Jawab</label>
                    <select name="therapis_id" id="therapis_id"
                            class="w-full">
                        <option value="">Belum Ditentukan</option>
                        @foreach($therapists as $therapist)
                            <option value="{{ $therapist->id }}" {{ old('therapis_id', $child->therapis_id) == $therapist->id ? 'selected' : '' }}>
                                {{ $therapist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('therapis_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Status Terapi (is_active) -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 block">Status Terapi</label>
                <div class="flex items-center gap-3 mt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $child->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="text-sm text-slate-600 font-medium">Aktif Terapi</label>
                </div>
                @error('is_active') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Catatan Medis -->
            <div class="space-y-2">
                <label for="catatan_medis" class="text-sm font-bold text-slate-700">Catatan Medis</label>
                <textarea name="catatan_medis" id="catatan_medis" rows="4"
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 placeholder-slate-400"
                          placeholder="Keluhan utama, diagnosis medis, atau catatan sensorik awal...">{{ old('catatan_medis', $child->catatan_medis) }}</textarea>
                @error('catatan_medis') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('children.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-800 transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-bold transition shadow-lg shadow-blue-200 active:scale-95">
                Perbarui Data Pasien
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('parent_id')) {
            new TomSelect('#parent_id', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Cari Nama Orang Tua...",
            });
        }

        new TomSelect('#therapis_id', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Cari Nama Terapis...",
        });
    });
</script>
@endpush
@endsection
