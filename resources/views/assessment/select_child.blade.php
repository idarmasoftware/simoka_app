@extends('layouts.app')

@section('title', 'Pilih Pasien - SI-MOKA')
@section('page_title', 'Mulai Assessment SSP')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Pilih Pasien (Anak)</h2>
        <p class="text-slate-500 mt-1">Silakan pilih anak untuk memulai proses assessment sensory.</p>
    </div>

    @if($children->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Pasien</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-6">Anda tidak memiliki pasien aktif yang ditugaskan kepada Anda saat ini.</p>
            <a href="{{ route('children.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pasien Baru
            </a>
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
                                <span class="text-slate-400">Tanggal Lahir:</span>
                                <span class="font-semibold text-slate-700">{{ $child->tanggal_lahir->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400">Usia:</span>
                                <span class="font-semibold text-slate-700">{{ $child->tanggal_lahir->age }} Tahun</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400">Orang Tua:</span>
                                <span class="font-semibold text-slate-700">{{ $child->parent->name }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('assessments.create', $child) }}" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition active:scale-95 shadow-lg shadow-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Mulai Assessment
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
