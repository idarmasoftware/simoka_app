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
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2.5 py-1 rounded-md">Short Sensory Profile</span>
                <h3 class="font-bold text-slate-800 text-xl mt-2">Hasil Penilaian Sensorik</h3>
            </div>
            <div class="text-sm text-slate-400">
                Tanggal: <strong class="text-slate-700 font-semibold">{{ $assessment->created_at->format('d M Y') }}</strong>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Info Pasien -->
                <div class="md:col-span-2 space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Pasien & Terapis</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Nama Anak</p>
                            <p class="text-slate-800 font-bold">{{ $assessment->child->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Terapis</p>
                            <p class="text-slate-800 font-bold">{{ $assessment->therapis->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Jenis Kelamin</p>
                            <p class="text-slate-800 font-bold">{{ $assessment->child->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Usia Saat Assessment</p>
                            <p class="text-slate-800 font-bold">{{ $assessment->child->tanggal_lahir->diff($assessment->created_at)->format('%y Tahun %m Bulan') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Hasil Klasifikasi & Skor -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col justify-between items-center text-center">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Skor Total SSP</p>
                        <span class="text-5xl font-black text-slate-800">{{ $assessment->score }}</span>
                        <span class="text-xs text-slate-400 block mt-1">dari 115 poin</span>
                    </div>

                    <div class="mt-4 w-full">
                        @php
                            $class = $assessment->result_classification;
                            $bg = 'bg-blue-50 border-blue-200 text-blue-700';
                            $label = 'Typical Performance';
                            
                            if ($class === 'Probable Difference') {
                                $bg = 'bg-amber-50 border-amber-200 text-amber-700';
                                $label = 'Probable Difference';
                            } elseif ($class === 'Definite Difference') {
                                $bg = 'bg-rose-50 border-rose-200 text-rose-700';
                                $label = 'Definite Difference';
                            }
                        @endphp
                        <div class="px-4 py-2 rounded-xl border text-xs font-bold {{ $bg }}">
                            {{ $label }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Medis -->
            @if($assessment->child->catatan_medis)
                <div class="border-t border-slate-100 pt-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Observasi Terapis</h4>
                    <p class="text-slate-600 bg-slate-50 border border-slate-100 p-4 rounded-xl text-sm leading-relaxed whitespace-pre-line">{{ $assessment->child->catatan_medis }}</p>
                </div>
            @endif
        </div>
    </div>

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
