@extends('layouts.app')

@section('title', 'Assessment SSP - SI-MOKA')
@section('page_title', 'Assessment SSP')

@section('content')
<div x-data="{
    answers: {},
    totalQuestions: 23,
    get progress() {
        let count = Object.keys(this.answers).length;
        return Math.round((count / this.totalQuestions) * 100);
    },
    get completedCount() {
        return Object.keys(this.answers).length;
    },
    selectAnswer(questionId, value) {
        this.answers[questionId] = value;
    }
}" class="max-w-5xl mx-auto pb-40">

    <!-- Informasi Pasien -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-6">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Informasi Pasien</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Anak</p>
                <p class="text-slate-800 font-bold text-lg">Ahmad Rizki</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Usia</p>
                <p class="text-slate-800 font-bold text-lg">4 tahun 3 bulan</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Assessment</p>
                <p class="text-slate-800 font-bold text-lg">20 Februari 2026</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Assessment Sebelumnya</p>
                <p class="text-slate-800 font-bold text-lg">15 November 2025</p>
            </div>
        </div>
    </div>

    <!-- Progress Pengisian -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-6">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-slate-800">Progress Pengisian</h3>
            <span class="text-blue-600 font-bold" x-text="completedCount + ' / ' + totalQuestions"></span>
        </div>
        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full bg-blue-600 transition-all duration-700 ease-out" :style="'width: ' + progress + '%'"></div>
        </div>
    </div>

    <!-- Panduan Pengisian -->
    <div class="bg-[#FFFBEB] rounded-2xl border border-[#FEF3C7] p-8 mb-10">
        <div class="flex gap-5">
            <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-900 mb-3 text-lg">Panduan Pengisian</h3>
                <ul class="text-amber-800/90 space-y-2.5">
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <p class="text-sm italic">Jawab setiap pertanyaan berdasarkan observasi perilaku anak dalam 6 bulan terakhir</p>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <p class="text-sm italic">Pilih frekuensi yang paling sesuai dengan kondisi anak</p>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <p class="text-sm italic">Konsultasikan dengan orang tua untuk perilaku yang terjadi di rumah</p>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <p class="text-sm italic font-semibold">Skor yang lebih tinggi menunjukkan kesulitan yang lebih besar dalam sensory processing</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form action="#" method="POST" class="space-y-12">
        @csrf

        @php
            $categories = [
                'Tactile Sensitivity' => [
                    1 => 'Menghindari atau tidak suka berjalan tanpa alas kaki, terutama di rumput atau pasir',
                    2 => 'Bereaksi secara emosional atau agresif ketika disentuh',
                    3 => 'Menarik diri dari percikan air atau tidak menyukai air mengenai wajah',
                    4 => 'Menghindari aktivitas yang melibatkan tangan kotor (cat, lem, pasir)',
                ],
                'Taste/Smell Sensitivity' => [
                    5 => 'Pilih-pilih makanan, terutama tekstur tertentu',
                    6 => 'Menghindari makanan dengan bau atau rasa tertentu',
                    7 => 'Sensitif terhadap bau yang tidak diperhatikan orang lain',
                ],
                'Movement Sensitivity' => [
                    8 => 'Menjadi cemas jika kaki diangkat dari tanah (misal: naik tangga, ayunan)',
                    9 => 'Menghindari peralatan bermain yang bergerak atau berputar',
                    10 => 'Sangat takut jatuh atau ketinggian',
                ],
                'Visual Sensitivity' => [
                    23 => 'Kesulitan menemukan objek di area yang ramai atau penuh'
                ]
            ];

            // Fill placeholders to make it 23
            for($i = 11; $i < 23; $i++) {
                $categories['Visual Sensitivity'][$i] = 'Indikator perilaku sensorik nomor ' . $i;
            }
            ksort($categories['Visual Sensitivity']);

            $options = [
                5 => 'Selalu',
                4 => 'Sering',
                3 => 'Kadang-kadang',
                2 => 'Jarang',
                1 => 'Tidak Pernah'
            ];
            $cat_index = 1;
        @endphp

        @foreach($categories as $cat_title => $questions)
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Kategori {{ $cat_index++ }}</span>
                <h3 class="font-bold text-slate-800 text-xl">{{ $cat_title }}</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($questions as $id => $text)
                <div class="p-8 space-y-6">
                    <p class="font-bold text-slate-800 text-lg leading-tight">{{ $id }}. {{ $text }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        @foreach($options as $val => $label)
                        <label class="cursor-pointer group relative">
                            <input type="radio" name="q{{ $id }}" value="{{ $val }}" class="sr-only" @click="selectAnswer({{ $id }}, {{ $val }})">
                            <div :class="answers[{{ $id }}] == {{ $val }} ? 'border-blue-600 bg-blue-50/50 ring-1 ring-blue-600' : 'border-slate-200 hover:border-blue-200 bg-white'"
                                 class="px-4 py-5 rounded-xl border-2 transition-all flex items-center gap-3">
                                <div :class="answers[{{ $id }}] == {{ $val }} ? 'border-blue-600 bg-blue-600 ring-4 ring-blue-100' : 'border-slate-300 bg-white group-hover:border-blue-400'"
                                     class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all flex-shrink-0">
                                    <div x-show="answers[{{ $id }}] == {{ $val }}" class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span :class="answers[{{ $id }}] == {{ $val }} ? 'text-blue-700 font-bold' : 'text-slate-600 font-medium'"
                                          class="text-sm">{{ $label }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5" x-text="'({{ $val }})'"></span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach

        <!-- Catatan Klinis -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <h3 class="font-bold text-slate-800 text-lg mb-6">Catatan Klinis & Rekomendasi</h3>
            <textarea name="clinical_notes" rows="6"
                      class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-6 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 placeholder-slate-400 text-base"
                      placeholder="Tulis observasi klinis, interpretasi hasil, dan rekomendasi terapi untuk orang tua..."></textarea>
        </div>

        <!-- Sticky Footer for Actions -->
        <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white/90 backdrop-blur-lg border-t border-slate-200 p-6 z-40 shadow-[0_-8px_30px_rgb(0,0,0,0.04)]">
            <div class="max-w-5xl mx-auto flex flex-col gap-5">
                <!-- Validation Alert -->
                <div x-show="completedCount < totalQuestions"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-amber-50 border border-amber-200 rounded-2xl px-6 py-4 flex items-center gap-4 text-amber-800 text-sm shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <span>Harap lengkapi semua <strong x-text="totalQuestions"></strong> pertanyaan sebelum submit assessment (Saat ini: <strong x-text="completedCount"></strong> pertanyaan terisi)</span>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <button type="button" class="w-full sm:w-auto flex-1 flex items-center justify-center gap-3 bg-white text-slate-700 border-2 border-slate-200 px-8 py-4.5 rounded-2xl font-bold hover:bg-slate-50 transition-all shadow-sm active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Draft
                    </button>
                    <button type="submit"
                            :disabled="completedCount < totalQuestions"
                            :class="completedCount < totalQuestions ? 'bg-blue-300 cursor-not-allowed opacity-70' : 'bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-200 active:scale-95'"
                            class="w-full sm:w-auto flex-[2] flex items-center justify-center gap-3 text-white px-8 py-4.5 rounded-2xl font-bold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Submit Assessment
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
