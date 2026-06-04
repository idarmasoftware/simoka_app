@extends('layouts.app')

@section('title', 'Progres Perkembangan - SI-MOKA')
@section('page_title', 'Progres Perkembangan')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-6">
        <a href="{{ route('assessments.progress') }}" class="text-blue-600 font-semibold hover:text-blue-700 text-sm flex items-center gap-1.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Pilihan Pasien
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Laporan Progres Perkembangan</h2>
        <p class="text-slate-500 mt-1">
            Membandingkan hasil assessment awal (Pre-Assessment) dan hasil terbaru (Post-Assessment) untuk <strong class="text-slate-700">{{ $selectedChild->nama_lengkap }}</strong>.
        </p>
    </div>

    @if(!$preAssessment || !$postAssessment || $preAssessment->id === $postAssessment->id)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl p-6 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-900">Data Belum Lengkap</h3>
                <p class="text-sm mt-1">Anak ini belum memiliki cukup data assessment untuk membandingkan progres. Diperlukan setidaknya dua assessment (Pre & Post).</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Pre-Assessment Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2.5 py-1 rounded-md">Assessment Awal</span>
                        <p class="text-slate-500 text-sm mt-2">{{ $preAssessment->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="text-center py-6 border-y border-slate-100">
                    <p class="text-sm font-semibold text-slate-500 mb-1">Skor Total</p>
                    <div class="text-5xl font-black text-slate-800">{{ $preAssessment->score }}</div>
                    <p class="text-xs text-slate-400 mt-2">dari maksimal 190</p>
                </div>
                <div class="mt-6 text-center">
                    <p class="text-sm font-semibold text-slate-500 mb-2">Klasifikasi Hasil</p>
                    @php
                        $preClass = 'bg-rose-50 text-rose-700 border-rose-200';
                        if ($preAssessment->result_classification === 'Typical Performance') $preClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        if ($preAssessment->result_classification === 'Probable Difference') $preClass = 'bg-amber-50 text-amber-700 border-amber-200';
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-xl text-sm font-bold border {{ $preClass }}">
                        {{ $preAssessment->result_classification }}
                    </span>
                </div>
            </div>

            <!-- Post-Assessment Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-8 relative overflow-hidden">
                <div class="flex justify-between items-center mb-6 relative z-10">
                    <div>
                        <span class="text-xs font-bold text-purple-700 uppercase tracking-widest bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">Assessment Terbaru</span>
                        <p class="text-slate-500 text-sm mt-2">{{ $postAssessment->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="text-center py-6 border-y border-slate-100 relative z-10">
                    <p class="text-sm font-semibold text-slate-500 mb-1">Skor Total</p>
                    <div class="text-5xl font-black text-slate-800">{{ $postAssessment->score }}</div>
                    <p class="text-xs text-slate-400 mt-2">dari maksimal 190</p>
                </div>
                <div class="mt-6 text-center relative z-10">
                    <p class="text-sm font-semibold text-slate-500 mb-2">Klasifikasi Hasil</p>
                    @php
                        $postClass = 'bg-rose-50 text-rose-700 border-rose-200';
                        if ($postAssessment->result_classification === 'Typical Performance') $postClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        if ($postAssessment->result_classification === 'Probable Difference') $postClass = 'bg-amber-50 text-amber-700 border-amber-200';
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-xl text-sm font-bold border {{ $postClass }}">
                        {{ $postAssessment->result_classification }}
                    </span>
                </div>
                
                <!-- Background decoration for latest -->
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-purple-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
            </div>
        </div>

        <!-- Summary & Conclusion -->
        @php
            $diff = $postAssessment->score - $preAssessment->score;
            $isImproved = $diff > 0;
            $isSame = $diff === 0;
            $isDeclined = $diff < 0;
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-8 flex items-start gap-6">
            @if($isImproved)
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Terjadi Peningkatan!</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Terdapat peningkatan skor sebesar <strong class="text-emerald-600 font-black">+{{ $diff }} poin</strong> dari assessment awal. 
                        Hal ini menunjukkan adanya perkembangan positif dari hasil terapi atau stimulasi yang telah dilakukan.
                    </p>
                </div>
            @elseif($isDeclined)
                <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Penurunan Skor</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Terdapat penurunan skor sebesar <strong class="text-rose-600 font-black">{{ $diff }} poin</strong>. 
                        Disarankan untuk berkonsultasi lebih lanjut dengan terapis untuk mengevaluasi program yang sedang berjalan.
                    </p>
                </div>
            @else
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Skor Tetap</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Tidak ada perubahan skor yang signifikan dibandingkan dengan assessment awal. 
                    </p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
