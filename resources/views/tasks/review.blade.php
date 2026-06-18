@extends('layouts.app')

@section('title', 'Tinjau Tugas Pasien - SI-MOKA')
@section('page_title', 'Tinjau Langkah Tugas')

@section('content')
<div class="max-w-4xl mx-auto pb-32">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-6">
        <a href="{{ route('tasks.index') }}" class="text-purple-600 font-semibold hover:text-purple-700 text-sm flex items-center gap-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Tugas
        </a>
    </div>

    <!-- Success & Error Alert -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Task Overview -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b border-slate-100">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest bg-purple-50 text-purple-700 px-2.5 py-1 rounded-md border border-purple-100">Tinjau Program Rumah</span>
                <h3 class="font-bold text-slate-800 text-2xl mt-3">{{ $task->title }}</h3>
                <p class="text-slate-500 text-sm mt-1">Pasien Anak: <strong class="text-slate-700 font-bold">{{ $task->child->nama_lengkap }}</strong></p>
            </div>
            <div class="flex items-center gap-3">
                @if(in_array($task->status, ['pending', 'in_progress', 'submitted']))
                <form id="remindForm_{{ $task->id }}" action="{{ route('tasks.remind', $task) }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmReminder('remindForm_{{ $task->id }}')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 px-3 py-1.5 rounded-full text-xs font-bold transition flex items-center gap-1.5 border border-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Kirim Reminder
                    </button>
                </form>
                @endif
                @php
                    $status = $task->status;
                    $badge = 'bg-slate-150 text-slate-700';
                    if ($status === 'in_progress') $badge = 'bg-blue-50 text-blue-700 border border-blue-150';
                    if ($status === 'submitted') $badge = 'bg-amber-50 text-amber-700 border border-amber-150';
                    if ($status === 'completed') $badge = 'bg-emerald-50 text-emerald-700 border border-emerald-150';
                @endphp
                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $badge }}">
                    Status: {{ ucfirst(str_replace('_', ' ', $status)) }}
                </span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi & Panduan Latihan</h4>
            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $task->description ?? 'Tidak ada instruksi tambahan dari terapis.' }}</p>
        </div>
    </div>

    <!-- Steps Review Timeline -->
    <h3 class="font-bold text-slate-800 text-lg mb-6">Review Video Langkah-per-Langkah</h3>
    <div class="space-y-8">
        @foreach($task->steps as $step)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Step Header -->
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-purple-600 text-white font-bold flex items-center justify-center text-sm flex-shrink-0">
                            {{ $step->step_number }}
                        </span>
                        <h4 class="font-bold text-slate-800 text-base">Langkah {{ $step->step_number }}</h4>
                    </div>
                    <div>
                        @php
                            $stepClass = $step->status;
                            $stepBadge = 'bg-slate-100 text-slate-500 border border-slate-200';
                            $stepLabel = 'Belum Ada Video';

                            if ($stepClass === 'uploaded') {
                                $stepBadge = 'bg-amber-50 text-amber-700 border border-amber-200';
                                $stepLabel = 'Perlu Review Anda';
                            } elseif ($stepClass === 'approved') {
                                $stepBadge = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                                $stepLabel = 'Disetujui';
                            } elseif ($stepClass === 'rejected') {
                                $stepBadge = 'bg-rose-50 text-rose-700 border border-rose-200';
                                $stepLabel = 'Perlu Perbaikan / Ditolak';
                            }
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $stepBadge }}">
                            {{ $stepLabel }}
                        </span>
                    </div>
                </div>

                <!-- Step Body -->
                <div class="p-6 md:p-8 space-y-6">
                    <div>
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Instruksi Langkah</h5>
                        <p class="text-slate-700 text-sm font-semibold">{{ $step->instruction }}</p>
                    </div>

                    @if($step->video_path)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-slate-100 pt-6">
                            <!-- Video Player & Notes -->
                            <div>
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Video Rekaman Orang Tua</h5>
                                <div class="rounded-xl overflow-hidden bg-slate-900 border border-slate-250 w-full aspect-video shadow-sm">
                                    <video controls class="w-full h-full object-contain">
                                        <source src="{{ asset('storage/' . $step->video_path) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                                @if($step->notes)
                                    <div class="mt-4 bg-slate-50 border border-slate-100 p-4 rounded-xl text-xs text-slate-600">
                                        <strong class="text-slate-700 font-bold block mb-1">Catatan Orang Tua:</strong>
                                        {{ $step->notes }}
                                    </div>
                                @endif
                            </div>

                            <!-- Review Form / Output -->
                            <div class="flex flex-col justify-between">
                                <form action="{{ route('tasks.steps.feedback', $step) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Keputusan</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status" value="approved" class="sr-only" {{ $step->status === 'approved' ? 'checked' : '' }} required>
                                                <div class="border-2 border-slate-200 rounded-xl py-3 px-4 text-center font-bold text-sm text-slate-600 hover:bg-slate-50 transition peer-checked:border-emerald-600 peer-checked:bg-emerald-50/50 peer-checked:text-emerald-700
                                                            [[type=radio]:checked+&]:border-emerald-600 [[type=radio]:checked+&]:bg-emerald-50/50 [[type=radio]:checked+&]:text-emerald-700">
                                                    Setujui (Approve)
                                                </div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status" value="rejected" class="sr-only" {{ $step->status === 'rejected' ? 'checked' : '' }} required>
                                                <div class="border-2 border-slate-200 rounded-xl py-3 px-4 text-center font-bold text-sm text-slate-600 hover:bg-slate-50 transition peer-checked:border-rose-600 peer-checked:bg-rose-50/50 peer-checked:text-rose-700
                                                            [[type=radio]:checked+&]:border-rose-600 [[type=radio]:checked+&]:bg-rose-50/50 [[type=radio]:checked+&]:text-rose-700">
                                                    Tolak / Perbaiki
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="feedback_{{ $step->id }}" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Feedback & Catatan Terapis</label>
                                        <textarea name="feedback" id="feedback_{{ $step->id }}" rows="3" required
                                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition outline-none text-slate-700 text-sm"
                                                  placeholder="Masukkan masukan klinis, koreksi gerakan, atau pujian untuk memotivasi anak/orang tua..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl shadow-md active:scale-95 transition-all text-sm">
                                        Simpan Review & Feedback
                                    </button>
                                </form>

                                @if($step->feedback && $step->status !== 'uploaded')
                                    <!-- Display saved feedback if already reviewed -->
                                    <div class="mt-4 p-4 rounded-xl border {{ $step->status === 'approved' ? 'bg-emerald-50/30 border-emerald-100 text-emerald-800' : 'bg-rose-50/30 border-rose-100 text-rose-800' }} text-xs">
                                        <div class="font-bold mb-1">Feedback Tersimpan Sebelumnya:</div>
                                        <div>{{ $step->feedback }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="border-t border-slate-100 pt-6 text-center py-6 text-slate-400 italic text-sm">
                            Menunggu orang tua melakukan latihan dan mengunggah video rekaman untuk langkah ini.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
