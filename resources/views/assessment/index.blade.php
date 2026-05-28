@extends('layouts.app')

@section('title', 'Riwayat Assessment - SI-MOKA')
@section('page_title', 'Riwayat Assessment')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(Auth::user()->isOrangTua() && !isset($selectedChild))
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-800">Pilih Anak</h2>
            <p class="text-slate-500 mt-1">Silakan pilih anak untuk melihat riwayat hasil assessment mereka.</p>
        </div>

        @if($children->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Anak Terdaftar</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Anda belum mendaftarkan anak Anda ke dalam sistem.</p>
                <a href="{{ route('children.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    Daftarkan Anak
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($children as $child)
                    <a href="{{ route('assessments.index', ['child_id' => $child->id]) }}" 
                       class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:border-blue-300 hover:shadow-md transition duration-200 block text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $child->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }} flex items-center justify-center font-bold text-xl flex-shrink-0 group-hover:scale-105 transition-all">
                                {{ substr($child->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg leading-snug group-hover:text-blue-600 transition">{{ $child->nama_lengkap }}</h3>
                                <span class="text-xs text-slate-400 block mt-0.5">{{ $child->tanggal_lahir->diff(now())->format('%y Tahun %m Bulan') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    @else
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Daftar Riwayat Assessment
                    @if(isset($selectedChild))
                        <span class="text-blue-600 font-bold block sm:inline sm:ml-2">({{ $selectedChild->nama_lengkap }})</span>
                    @endif
                </h2>
                <p class="text-slate-500 mt-1">Kelola dan lihat seluruh riwayat pengisian kuesioner Short Sensory Profile (SSP).</p>
            </div>
            <div class="flex items-center gap-3">
                @if(Auth::user()->isOrangTua() && isset($selectedChild))
                    <a href="{{ route('assessments.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-slate-600 border border-slate-200 font-bold px-4 py-3 rounded-xl hover:bg-slate-50 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Pilih Anak Lain
                    </a>
                @endif
                @if(Auth::user()->isTerapis())
                    <a href="{{ route('assessments.select_child') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-3 rounded-xl shadow-lg shadow-blue-100 transition active:scale-95 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Assessment Baru
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($assessments->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Tidak Ada Riwayat</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">Sistem belum mencatat adanya pengisian kuesioner assessment untuk anak ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="p-5">Nama Anak</th>
                                @if(Auth::user()->isTerapis())
                                    <th class="p-5">Orang Tua</th>
                                @else
                                    <th class="p-5">Terapis</th>
                                @endif
                                <th class="p-5">Tanggal</th>
                                <th class="p-5 text-center">Skor SSP</th>
                                <th class="p-5">Hasil Klasifikasi</th>
                                <th class="p-5">Tugas Rumah</th>
                                <th class="p-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                            @foreach($assessments as $assessment)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-5 font-bold text-slate-800">{{ $assessment->child->nama_lengkap }}</td>
                                    @if(Auth::user()->isTerapis())
                                        <td class="p-5">{{ $assessment->child->parent->name }}</td>
                                    @else
                                        <td class="p-5">{{ $assessment->therapis->name }}</td>
                                    @endif
                                    <td class="p-5">{{ $assessment->created_at->format('d M Y') }}</td>
                                    <td class="p-5 text-center font-black text-slate-800 text-base">{{ $assessment->score }}</td>
                                    <td class="p-5">
                                        @php
                                            $class = $assessment->result_classification;
                                            $badge = 'bg-blue-50 text-blue-700 border border-blue-100';
                                            if ($class === 'Probable Difference') $badge = 'bg-amber-50 text-amber-700 border border-amber-100';
                                            if ($class === 'Definite Difference') $badge = 'bg-rose-50 text-rose-700 border border-rose-100';
                                        @endphp
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $badge }}">
                                            {{ $class }}
                                        </span>
                                    </td>
                                    <td class="p-5">
                                        @if($assessment->task)
                                            @php
                                                $taskStatus = $assessment->task->status;
                                                $taskBadge = 'bg-slate-100 text-slate-600';
                                                if ($taskStatus === 'in_progress') $taskBadge = 'bg-blue-100 text-blue-700';
                                                if ($taskStatus === 'submitted') $taskBadge = 'bg-amber-150 text-amber-800';
                                                if ($taskStatus === 'completed') $taskBadge = 'bg-emerald-100 text-emerald-700';
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-bold {{ $taskBadge }}">
                                                {{ ucfirst(str_replace('_', ' ', $taskStatus)) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Belum Diberikan</span>
                                        @endif
                                    </td>
                                    <td class="p-5 text-center">
                                        <a href="{{ route('assessments.show', $assessment) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-bold hover:underline">
                                            Detail &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($assessments->hasPages())
                    <div class="p-5 border-t border-slate-100">
                        {{ $assessments->links() }}
                    </div>
                @endif
            @endif
        </div>
    @endif
</div>
@endsection
