@extends('layouts.app')

@section('title', 'Pilih Pasien untuk Progres - SI-MOKA')
@section('page_title', 'Progres Perkembangan')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Pilih Pasien (Anak)</h2>
        <p class="text-slate-500 mt-1">Silakan pilih anak untuk melihat perbandingan skor Assessment awal (Pre) dan akhir (Post).</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <p class="font-medium text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
        <form action="{{ route('assessments.progress') }}" method="GET" class="flex flex-col lg:flex-row flex-wrap items-center gap-4">
            <div class="w-full lg:flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anak..." autocomplete="off" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="w-full lg:w-48">
                <select name="gender" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full sm:w-auto bg-blue-50 text-blue-600 hover:bg-blue-100 px-6 py-2 rounded-xl font-medium transition text-sm">Cari</button>
            </div>
            @if(request()->hasAny(['search', 'gender']))
            <div>
                <a href="{{ route('assessments.progress') }}" class="flex items-center justify-center w-full sm:w-auto bg-slate-50 text-slate-500 hover:bg-slate-100 px-4 py-2 rounded-xl font-medium transition text-sm">Reset</a>
            </div>
            @endif
        </form>
    </div>

    @if($children->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Pasien</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-6">Anda tidak memiliki pasien aktif yang ditugaskan kepada Anda saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($children as $child)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between hover:border-blue-300 hover:shadow-md transition duration-200">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl {{ $child->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }} flex items-center justify-center font-bold text-xl flex-shrink-0">
                                {{ substr($child->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg leading-snug">{{ $child->nama_lengkap }}</h3>
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-0.5 rounded-full mt-1 {{ $child->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                    {{ $child->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 border-t border-slate-100 pt-4 mb-6">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400">Total Assessment:</span>
                                <span class="font-semibold text-slate-700">{{ $child->assessments()->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('assessments.progress', ['child_id' => $child->id]) }}" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition active:scale-95 shadow-lg shadow-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        Lihat Progres
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
