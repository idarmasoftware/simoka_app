@extends('layouts.app')

@section('title', 'Hasil Assessment - SI-MOKA')
@section('page_title', 'Hasil Assessment SSP')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Main Results Card -->
    <!-- Informasi Pasien -->
    <div class="bg-[#EFF6FF]/60 rounded-2xl border border-blue-200 shadow-sm p-8 mb-6">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-blue-900">Informasi Pasien</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-blue-500/70 uppercase tracking-wider">Nama Anak</p>
                <p class="text-blue-950 font-bold text-lg leading-tight">{{ $assessment->child->nama_lengkap }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-blue-500/70 uppercase tracking-wider">Usia</p>
                <p class="text-blue-950 font-bold text-lg leading-tight">{{ $assessment->child->tanggal_lahir->diff($assessment->created_at)->format('%y tahun %m bulan') }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-blue-500/70 uppercase tracking-wider">Tanggal Assessment</p>
                <p class="text-blue-950 font-bold text-lg leading-tight">{{ $assessment->created_at->translatedFormat('d F Y') }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-semibold text-blue-500/70 uppercase tracking-wider">Terapis</p>
                <p class="text-blue-950 font-bold text-lg leading-tight">{{ $assessment->therapis->name }}</p>
            </div>
        </div>
    </div>

    <!-- Interpretasi Keseluruhan -->
    @php
        $class = $assessment->result_classification;
        $score = $assessment->score;
        $percentage = round(($score / 190) * 100);

        if ($class === 'Typical Performance') {
            $cardBg = 'bg-emerald-50/50 border-emerald-200';
            $titleColor = 'text-emerald-900';
            $descColor = 'text-emerald-800/80';
            $iconBg = 'bg-emerald-100 text-emerald-600';
            $title = 'Kinerja Tipikal (Typical Performance)';
            $desc = 'Anak menunjukkan fungsi pemrosesan sensorik yang khas/tipikal dalam kehidupan sehari-hari. Tidak ada indikasi gangguan sensorik yang signifikan.';
            $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>';
        } elseif ($class === 'Probable Difference') {
            $cardBg = 'bg-amber-50/50 border-amber-200';
            $titleColor = 'text-amber-900';
            $descColor = 'text-amber-800/80';
            $iconBg = 'bg-amber-100 text-amber-600';
            $title = 'Perbedaan Mungkin (Probable Difference)';
            $desc = 'Anak menunjukkan kemungkinan adanya perbedaan/gangguan ringan hingga sedang dalam pemrosesan sensorik. Disarankan pemantauan atau stimulasi terarah.';
            $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        } else { // Definite Difference
            $cardBg = 'bg-rose-50/50 border-rose-200';
            $titleColor = 'text-rose-900';
            $descColor = 'text-rose-800/80';
            $iconBg = 'bg-rose-100 text-rose-600';
            $title = 'Memerlukan Intervensi Segera';
            $desc = 'Anak menunjukkan kesulitan signifikan di beberapa area sensory processing. Intervensi terapi okupasi segera direkomendasikan.';
            $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>';
        }
    @endphp

    <div class="rounded-2xl border p-8 mb-8 shadow-sm flex flex-col md:flex-row items-start gap-6 {{ $cardBg }}">
        <div class="w-14 h-14 rounded-full flex items-center justify-center flex-shrink-0 {{ $iconBg }}">
            {!! $iconSvg !!}
        </div>
        <div class="flex-1 space-y-4">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Interpretasi Keseluruhan</span>
                <h3 class="text-2xl font-extrabold leading-tight {{ $titleColor }}">{{ $title }}</h3>
                <p class="text-sm mt-2 leading-relaxed {{ $descColor }}">{{ $desc }}</p>
            </div>
            
            <div class="flex gap-10 border-t border-slate-200/50 pt-4">
                <div>
                    <span class="text-xs text-slate-500 font-medium block">Total Skor</span>
                    <span class="text-3xl font-black text-slate-800">{{ $score }} <span class="text-base font-normal text-slate-400">/ 190</span></span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 font-medium block">Persentase</span>
                    <span class="text-3xl font-black text-slate-800">{{ $percentage }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Breakdown Skor per Kategori -->
    <div class="mb-10">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Breakdown Skor per Kategori</h3>
        
        <div class="space-y-4">
            @foreach($assessment->domain_breakdown as $key => $data)
                @php
                    $dClass = $data['classification'];
                    if ($dClass === 'Typical Performance') {
                        $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        $barBg = 'bg-emerald-500';
                        $iconClass = 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>';
                    } elseif ($dClass === 'Probable Difference') {
                        $badgeBg = 'bg-amber-50 text-amber-700 border-amber-200';
                        $barBg = 'bg-amber-500';
                        $iconClass = 'bg-amber-50 text-amber-600 border border-amber-100';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                    } else { // Definite Difference
                        $badgeBg = 'bg-rose-50 text-rose-700 border-rose-200';
                        $barBg = 'bg-rose-500';
                        $iconClass = 'bg-rose-50 text-rose-600 border border-rose-100';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>';
                    }
                @endphp
                
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $iconClass }}">
                                {!! $iconHtml !!}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-base leading-snug">{{ $data['name'] }}</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Skor: <strong class="text-slate-600 font-bold">{{ $data['score'] }}</strong> / {{ $data['max_score'] }} ({{ $data['percentage'] }}%)</p>
                            </div>
                        </div>
                        <span class="px-3.5 py-1.5 rounded-xl border text-xs font-bold {{ $badgeBg }}">
                            {{ $dClass }}
                        </span>
                    </div>
                    
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 ease-out {{ $barBg }}" style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Ringkasan Observasi Terapis -->
    @if($assessment->child->catatan_medis)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-6">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Catatan Observasi Terapis</h4>
            <p class="text-slate-600 bg-slate-50 border border-slate-100 p-6 rounded-xl text-sm leading-relaxed whitespace-pre-line">{{ $assessment->child->catatan_medis }}</p>
        </div>
    @endif

    <!-- Recommendations & Homework Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Rekomendasi & Tugas Rumah</h3>
                <p class="text-xs text-slate-500">Tugas stimulasi terstruktur untuk dilakukan orang tua di rumah</p>
            </div>
        </div>

        <div class="p-8">
            @if($assessment->task)
                <!-- Task already exists -->
                <div class="bg-purple-50/50 rounded-2xl border border-purple-100 p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <h4 class="text-lg font-bold text-slate-800">{{ $assessment->task->title }}</h4>
                            <p class="text-slate-500 text-xs mt-1">Diberikan oleh Terapis pada {{ $assessment->task->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            @php
                                $status = $assessment->task->status;
                                $badge = 'bg-slate-100 text-slate-700';
                                if ($status === 'in_progress') $badge = 'bg-blue-50 text-blue-700 border border-blue-100';
                                if ($status === 'submitted') $badge = 'bg-amber-50 text-amber-700 border border-amber-100';
                                if ($status === 'completed') $badge = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                Status: {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-slate-600 text-sm mb-6 leading-relaxed">{{ $assessment->task->description }}</p>

                    <h5 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-3">Langkah-langkah Tugas:</h5>
                    <div class="space-y-3">
                        @foreach($assessment->task->steps as $step)
                            <div class="flex items-start gap-3 bg-white p-4 rounded-xl border border-slate-150">
                                <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                                    {{ $step->step_number }}
                                </span>
                                <div>
                                    <p class="text-slate-700 text-sm leading-normal">{{ $step->instruction }}</p>
                                    @if($step->status !== 'pending')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold mt-2 px-2 py-0.5 rounded {{ $step->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($step->status === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                                            {{ ucfirst($step->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    @if(Auth::user()->isTerapis())
                        <a href="{{ route('tasks.review', $assessment->task) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-blue-100 active:scale-95 transition-all">
                            Review Video Tugas Orang Tua
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('tasks.show', $assessment->task) }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 active:scale-95 transition-all">
                            Kerjakan & Upload Video Tugas
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                </div>

            @else
                <!-- No task assigned yet -->
                @if(Auth::user()->isTerapis())
                    <!-- Therapist Form to Assign Tasks -->
                    <form action="{{ route('tasks.store') }}" method="POST" x-data="{
                        title: '',
                        description: '',
                        steps: ['Stimulasi awal (sesuai kebutuhan anak)'],
                        loadExistingTask(event) {
                            const val = event.target.value;
                            if (val) {
                                const selectedOption = event.target.options[event.target.selectedIndex];
                                const taskData = JSON.parse(selectedOption.getAttribute('data-task'));
                                this.title = taskData.title || '';
                                this.description = taskData.description || '';
                                if (taskData.steps && taskData.steps.length > 0) {
                                    this.steps = taskData.steps.map(s => s.instruction);
                                } else {
                                    this.steps = [''];
                                }
                            }
                        },
                        addStep() {
                            this.steps.push('');
                        },
                        removeStep(index) {
                            if (this.steps.length > 1) {
                                this.steps.splice(index, 1);
                            }
                        }
                    }">
                        @csrf
                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

                        <div class="space-y-6">
                            @if($existingTasks->isNotEmpty())
                                <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl">
                                    <label for="existing_task" class="block text-sm font-bold text-slate-700 mb-2">Gunakan Kembali Tugas yang Sudah Ada (Reusable Task)</label>
                                    <select id="existing_task" @change="loadExistingTask($event)"
                                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition outline-none text-slate-700 text-sm">
                                        <option value="">-- Buat Tugas Baru dari Awal --</option>
                                        @foreach($existingTasks as $existingTask)
                                            <option value="{{ $existingTask->id }}" data-task="{{ json_encode($existingTask) }}">
                                                {{ $existingTask->title }} ({{ count($existingTask->steps) }} langkah)
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-slate-400 mt-2">Memilih tugas yang ada akan menduplikasi judul, deskripsi, dan langkah-langkahnya.</p>
                                </div>
                            @endif

                            <div>
                                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Nama / Judul Tugas</label>
                                <input type="text" name="title" id="title" required x-model="title"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition outline-none text-slate-700 text-sm"
                                       placeholder="Contoh: Terapi Stimulasi Taktil Sendok Halus-Kasar">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Instruksi & Deskripsi Umum</label>
                                <textarea name="description" id="description" rows="3" x-model="description"
                                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition outline-none text-slate-700 text-sm"
                                          placeholder="Tuliskan tujuan tugas, durasi pengerjaan, dan saran pelaksanaannya..."></textarea>
                            </div>

                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-slate-700">Langkah-langkah Tugas (Step-by-Step)</label>
                                <p class="text-xs text-slate-400 -mt-2">Orang tua akan mengunggah video rekaman terpisah untuk tiap langkah yang Anda buat di bawah ini.</p>

                                <div class="space-y-3">
                                    <template x-for="(step, index) in steps" :key="index">
                                        <div class="flex gap-3 items-center">
                                            <span class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-bold flex items-center justify-center flex-shrink-0 text-xs" x-text="index + 1"></span>
                                            <input type="text" name="steps[]" required :value="step"
                                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition outline-none text-slate-700 text-sm"
                                                   placeholder="Instruksi untuk langkah ini..." x-model="steps[index]">
                                            <button type="button" @click="removeStep(index)" :disabled="steps.length === 1"
                                                    class="p-3 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-xl border border-slate-200 transition disabled:opacity-40 disabled:hover:bg-slate-50 disabled:hover:text-slate-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <button type="button" @click="addStep" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-bold text-sm mt-2 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Langkah
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 border-t border-slate-100 pt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-blue-100 active:scale-95 transition-all text-sm">
                                Berikan Tugas & Rekomendasi
                            </button>
                        </div>
                    </form>
                @else
                    <!-- For parent, waiting therapist -->
                    <div class="text-center py-8">
                        <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Tugas Belum Diberikan</h4>
                        <p class="text-slate-500 text-xs max-w-sm mx-auto">Terapis belum merumuskan tugas stimulasi rumah untuk hasil assessment ini. Silakan hubungi terapis Anda.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
