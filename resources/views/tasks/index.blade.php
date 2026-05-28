@extends('layouts.app')

@section('title', 'Tugas Rumah - SI-MOKA')
@section('page_title', 'Kelola Tugas Rumah')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Tugas Rumah (Home Program)</h2>
        <p class="text-slate-500 mt-1">
            @if(Auth::user()->isTerapis())
                Kelola dan tinjau kemajuan latihan stimulasi mandiri yang diberikan ke pasien di rumah.
            @else
                Daftar program latihan mandiri untuk anak yang perlu dilakukan dan didokumentasikan di rumah.
            @endif
        </p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($tasks->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Tidak Ada Tugas</h3>
                <p class="text-slate-500 max-w-sm mx-auto">Belum ada tugas rumah yang aktif saat ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="p-5">Judul Tugas</th>
                            <th class="p-5">Nama Anak</th>
                            @if(Auth::user()->isTerapis())
                                <th class="p-5">Orang Tua</th>
                            @else
                                <th class="p-5">Terapis</th>
                            @endif
                            <th class="p-5 text-center">Kemajuan Langkah</th>
                            <th class="p-5">Status</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @foreach($tasks as $task)
                            @php
                                $totalSteps = $task->steps()->count();
                                $completedSteps = $task->steps()->where('status', 'approved')->count();
                                $uploadedSteps = $task->steps()->whereIn('status', ['uploaded', 'approved', 'rejected'])->count();
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-5">
                                    <div class="font-bold text-slate-800">{{ $task->title }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5 max-w-xs truncate">{{ $task->description }}</div>
                                </td>
                                <td class="p-5 font-semibold text-slate-700">{{ $task->child->nama_lengkap }}</td>
                                @if(Auth::user()->isTerapis())
                                    <td class="p-5">{{ $task->child->parent->name }}</td>
                                @else
                                    <td class="p-5">{{ $task->therapis->name }}</td>
                                @endif
                                <td class="p-5 text-center">
                                    <div class="flex items-center flex-col justify-center gap-1.5">
                                        <div class="w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-purple-600 h-full transition-all" style="width: {{ $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-500">
                                            {{ $completedSteps }} / {{ $totalSteps }} Disetujui
                                        </span>
                                        @if($uploadedSteps > $completedSteps)
                                            <span class="text-[10px] text-amber-600 font-semibold">({{ $uploadedSteps }} terupload)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-5">
                                    @php
                                        $status = $task->status;
                                        $badge = 'bg-slate-100 text-slate-700';
                                        if ($status === 'in_progress') $badge = 'bg-blue-50 text-blue-700 border border-blue-100';
                                        if ($status === 'submitted') $badge = 'bg-amber-50 text-amber-700 border border-amber-100';
                                        if ($status === 'completed') $badge = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold {{ $badge }}">
                                        @if($status === 'pending')
                                            Menunggu Video
                                        @elseif($status === 'in_progress')
                                            Dalam Proses
                                        @elseif($status === 'submitted')
                                            Perlu Review
                                        @elseif($status === 'completed')
                                            Selesai
                                        @else
                                            {{ ucfirst($status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="p-5 text-center">
                                    @if(Auth::user()->isTerapis())
                                        <a href="{{ route('tasks.review', $task) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-bold hover:underline">
                                            Review &rarr;
                                        </a>
                                    @else
                                        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center gap-1.5 text-purple-600 hover:text-purple-700 font-bold hover:underline">
                                            Kerjakan &rarr;
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
                <div class="p-5 border-t border-slate-100">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
