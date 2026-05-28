@extends('layouts.app')

@section('title', 'Detail Tugas Rumah - SI-MOKA')
@section('page_title', 'Detail Tugas Rumah')

@section('content')
<div class="max-w-4xl mx-auto pb-32">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-6">
        <a href="{{ route('tasks.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 text-sm flex items-center gap-1.5 transition">
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
    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <p class="font-medium text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Task Overview -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b border-slate-100">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest bg-purple-50 text-purple-700 px-2.5 py-1 rounded-md border border-purple-100">Program Terapi Mandiri</span>
                <h3 class="font-bold text-slate-800 text-2xl mt-3">{{ $task->title }}</h3>
                <p class="text-slate-500 text-sm mt-1">Untuk anak: <strong class="text-slate-700 font-bold">{{ $task->child->nama_lengkap }}</strong></p>
            </div>
            <div>
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

        <div class="grid grid-cols-2 gap-4 mt-6 border-t border-slate-100 pt-6">
            <div>
                <p class="text-xs text-slate-400">Terapis Penanggung Jawab</p>
                <p class="text-slate-700 font-bold text-sm mt-0.5">{{ $task->therapis->name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Tanggal Diberikan</p>
                <p class="text-slate-700 font-bold text-sm mt-0.5">{{ $task->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Steps Timeline -->
    <h3 class="font-bold text-slate-800 text-lg mb-6">Langkah-langkah Tugas (Selesaikan Berurutan)</h3>
    <div class="space-y-8">
        @foreach($task->steps as $index => $step)
            @php
                $isLocked = false;
                if ($index > 0) {
                    $prevStep = $task->steps[$index - 1];
                    if ($prevStep->status !== 'approved') {
                        $isLocked = true;
                    }
                }
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Step Header -->
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full {{ $isLocked ? 'bg-slate-300 text-slate-500' : 'bg-purple-600 text-white' }} font-bold flex items-center justify-center text-sm flex-shrink-0">
                            {{ $step->step_number }}
                        </span>
                        <h4 class="font-bold {{ $isLocked ? 'text-slate-400' : 'text-slate-800' }} text-base">Langkah {{ $step->step_number }}</h4>
                    </div>
                    <div>
                        @php
                            $stepClass = $step->status;
                            $stepBadge = 'bg-slate-100 text-slate-500 border border-slate-200';
                            $stepLabel = 'Menunggu Upload';

                            if ($isLocked) {
                                $stepBadge = 'bg-slate-100 text-slate-450 border border-slate-200';
                                $stepLabel = 'Terkunci';
                            } elseif ($stepClass === 'uploaded') {
                                $stepBadge = 'bg-amber-50 text-amber-700 border border-amber-200';
                                $stepLabel = 'Menunggu Review Terapis';
                            } elseif ($stepClass === 'approved') {
                                $stepBadge = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                                $stepLabel = 'Selesai / Disetujui';
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
                    @if($isLocked)
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-150 text-slate-400 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h5 class="font-bold text-slate-700 text-sm mb-1">Langkah Terkunci</h5>
                            <p class="text-xs text-slate-400 max-w-sm">Selesaikan langkah {{ $step->step_number - 1 }} dan tunggu persetujuan dari terapis terlebih dahulu.</p>
                        </div>
                    @else
                        <div>
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Instruksi Langkah</h5>
                            <p class="text-slate-700 text-base leading-relaxed">{{ $step->instruction }}</p>
                        </div>

                        @if($step->video_path)
                            <!-- Uploaded Video Player -->
                            <div class="border-t border-slate-100 pt-6">
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Video Rekaman Pengerjaan Anda</h5>
                                <div class="rounded-xl overflow-hidden bg-slate-900 border border-slate-200 max-w-lg aspect-video">
                                    <video controls class="w-full h-full object-contain">
                                        <source src="{{ asset('storage/' . $step->video_path) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                                @if($step->notes)
                                    <div class="mt-4 bg-slate-50 border border-slate-100 p-4 rounded-xl text-sm text-slate-600">
                                        <strong class="text-slate-700 font-bold block mb-1">Catatan Anda:</strong>
                                        {{ $step->notes }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($step->feedback)
                            <!-- Therapist Feedback -->
                            <div class="bg-blue-50 border border-blue-150 p-5 rounded-xl">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Feedback & Catatan Terapis:</span>
                                </div>
                                <p class="text-blue-800 text-sm leading-relaxed font-medium">{{ $step->feedback }}</p>
                            </div>
                        @endif

                        @if($step->status === 'pending' || $step->status === 'rejected')
                            <!-- Video Upload Form -->
                            <div class="border-t border-slate-100 pt-6">
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Unggah Rekaman Latihan</h5>
                                
                                <form action="{{ route('tasks.steps.upload', $step) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih File Video</label>
                                            <div class="relative flex items-center justify-center w-full border-2 border-dashed border-slate-200 hover:border-purple-300 rounded-xl p-6 transition group cursor-pointer bg-slate-50 hover:bg-purple-50/20">
                                                <input type="file" name="video" required accept="video/*"
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                       onchange="document.getElementById('fileName_{{ $step->id }}').innerText = this.files[0] ? this.files[0].name : 'Pilih file video...'">
                                                <div class="text-center">
                                                    <svg class="w-8 h-8 text-slate-400 group-hover:text-purple-600 mx-auto mb-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    <p id="fileName_{{ $step->id }}" class="text-sm font-semibold text-slate-600 group-hover:text-purple-700 transition">Klik untuk pilih video (Maks 50MB)</p>
                                                    <p class="text-[10px] text-slate-400 mt-1">Mendukung format .mp4, .mov, .webm, .avi</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="notes_{{ $step->id }}" class="block text-sm font-bold text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                                            <textarea name="notes" id="notes_{{ $step->id }}" rows="3"
                                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition outline-none text-slate-700 text-sm"
                                                      placeholder="Tuliskan catatan proses latihan, kendala anak, atau observasi Anda selama latihan langkah ini..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-5 flex justify-end">
                                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 active:scale-95 transition-all text-sm">
                                            Unggah & Kirim Langkah {{ $step->step_number }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
