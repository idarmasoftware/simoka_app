@extends('layouts.app')

@section('title', 'Dashboard - SIMONITA')
@section('page_title', 'Dashboard Perkembangan')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->name }}</h2>
    <p class="text-slate-500 mt-1">
        @if(auth()->user()->isSuperAdmin())
            Dashboard Super Administrator
        @elseif(auth()->user()->isTerapis())
            Dashboard Terapis Okupasi
        @elseif(auth()->user()->isOrangTua())
            Dashboard Orang Tua Pasien
        @endif
    </p>
</div>

@if(auth()->user()->isSuperAdmin())
    <!-- Dashboard Super Admin -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:shadow-md">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Terapis</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalTerapis }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:shadow-md">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Orang Tua</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalOrangTua }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:shadow-md">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pasien Anak</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalAnak }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:shadow-md">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Assessment</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalAssessment }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <a href="{{ route('users.index') }}" class="bg-white border border-slate-200 p-6 rounded-2xl hover:border-blue-300 hover:shadow-md transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Kelola Akun User</h3>
                    <p class="text-sm text-slate-500">Tambah, ubah, atau hapus akses pengguna</p>
                </div>
            </div>
            <div class="text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
        <a href="{{ route('children.index') }}" class="bg-white border border-slate-200 p-6 rounded-2xl hover:border-purple-300 hover:shadow-md transition flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Kelola Data Pasien</h3>
                    <p class="text-sm text-slate-500">Pantau seluruh pasien yang terdaftar di sistem</p>
                </div>
            </div>
            <div class="text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
    </div>

@elseif(auth()->user()->isTerapis())
    <!-- Dashboard Terapis -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:-translate-y-1 hover:shadow-lg">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pasien</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalPasien }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:-translate-y-1 hover:shadow-lg">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Assessment Pending</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $assessmentPending }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-400 text-white flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:-translate-y-1 hover:shadow-lg">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Langkah Menunggu Review</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $langkahMenungguReview }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center transition hover:-translate-y-1 hover:shadow-lg">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Assessment Selesai Bulan Ini</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $assessmentSelesaiBulanIni }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-[#F0F7FF] border border-[#D6E8FF] p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl transition duration-300">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-blue-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800">Assessment SSP</h3>
                        <p class="text-blue-600 font-medium text-xs sm:text-sm">Sensory Short Profile</p>
                    </div>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Isi assessment berbasis kuesioner SSP untuk evaluasi sensory processing anak.
                </p>
            </div>
            <div class="flex items-center justify-between mt-auto">
                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full border border-blue-200">{{ $assessmentPending }} Pending</span>
                <a href="{{ route('assessments.select_child') }}" class="text-blue-600 font-semibold hover:text-blue-700 text-sm flex items-center gap-1 transition">
                    Mulai &rarr;
                </a>
            </div>
        </div>

        <div class="bg-[#F8F5FF] border border-[#E9D5FF] p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl transition duration-300">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-purple-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800">Riwayat Assessment</h3>
                        <p class="text-purple-600 font-medium text-xs sm:text-sm">Hasil Kuisioner & Evaluasi</p>
                    </div>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Lihat hasil evaluasi yang telah diselesaikan untuk referensi tugas.
                </p>
            </div>
            <div class="flex items-center justify-between mt-auto">
                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full border border-purple-200">History</span>
                <a href="{{ route('assessments.index') }}" class="text-purple-600 font-semibold hover:text-purple-700 text-sm flex items-center gap-1 transition">
                    Lihat Riwayat &rarr;
                </a>
            </div>
        </div>

        <div class="bg-[#FFF8F0] border border-[#FFEDD5] p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl transition duration-300">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-orange-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800">Review Langkah Tugas</h3>
                        <p class="text-orange-600 font-medium text-xs sm:text-sm">Approve/Reject Steps</p>
                    </div>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Review dan approve langkah-langkah tugas yang disubmit orang tua.
                </p>
            </div>
            <div class="flex items-center justify-between mt-auto">
                <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full border border-orange-200">{{ $langkahMenungguReview }} Langkah Pending</span>
                <a href="{{ route('tasks.index', ['status' => 'submitted']) }}" class="text-orange-600 font-semibold hover:text-orange-700 text-sm flex items-center gap-1 transition">
                    Review &rarr;
                </a>
            </div>
        </div>
    </div>

@elseif(auth()->user()->isOrangTua())
    <!-- Dashboard Orang Tua -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-6 rounded-2xl shadow-lg shadow-blue-200 flex justify-between items-center text-white transition hover:scale-[1.02]">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Anak Terdaftar</p>
                <h3 class="text-3xl font-bold">{{ $anakTerdaftar }}</h3>
            </div>
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 p-6 rounded-2xl shadow-lg shadow-purple-200 flex justify-between items-center text-white transition hover:scale-[1.02]">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Tugas Sedang Berjalan</p>
                <h3 class="text-3xl font-bold">{{ $tugasBerjalan }}</h3>
            </div>
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-700 p-6 rounded-2xl shadow-lg shadow-orange-200 flex justify-between items-center text-white transition hover:scale-[1.02]">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Tugas Perlu Diunggah</p>
                <h3 class="text-3xl font-bold">{{ $langkahPerluDiunggah }}</h3>
            </div>
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <a href="{{ route('tasks.index') }}" class="bg-gradient-to-r from-purple-50 to-white border border-purple-100 shadow-sm p-6 rounded-2xl hover:border-purple-300 hover:shadow-md transition flex items-center justify-between group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Lanjutkan Tugas Rumah</h3>
                    <p class="text-sm text-slate-500">Unggah video dokumentasi kemajuan anak Anda.</p>
                </div>
            </div>
            <div class="text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>

        @if($assessmentTerakhir)
        <a href="{{ route('assessments.show', $assessmentTerakhir) }}" class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 shadow-sm p-6 rounded-2xl hover:border-blue-300 hover:shadow-md transition flex items-center justify-between group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Hasil Assessment Terakhir</h3>
                    <p class="text-sm text-slate-500">
                        {{ $assessmentTerakhir->child->nama_lengkap }} - Skor: {{ $assessmentTerakhir->score }}
                    </p>
                </div>
            </div>
            <div class="text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
        @else
        <a href="{{ route('assessments.index') }}" class="bg-gradient-to-r from-blue-50 to-white border border-blue-100 shadow-sm p-6 rounded-2xl hover:border-blue-300 hover:shadow-md transition flex items-center justify-between group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Riwayat Assessment</h3>
                    <p class="text-sm text-slate-500">Lihat semua hasil evaluasi yang pernah dilakukan.</p>
                </div>
            </div>
            <div class="text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
        @endif
    </div>

    @if($children->count() > 0)
    <div class="mt-8">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Tim Terapis Anak Anda</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @foreach($children as $child)
                @if($child->therapis)
                    <div class="bg-white border border-slate-200 p-5 rounded-2xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-lg">
                                {{ substr($child->therapis->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold mb-0.5">Terapis untuk {{ $child->nama_lengkap }}</p>
                                <h4 class="text-slate-800 font-bold">{{ $child->therapis->name }}</h4>
                            </div>
                        </div>
                        <div>
                            @php
                                $phone = $child->therapis->phone_number;
                                $waLink = $phone ? 'https://wa.me/' . preg_replace('/^0/', '62', $phone) : '#';
                                $onClick = $phone ? '' : 'alert(\'Nomor WhatsApp terapis belum tersedia.\'); return false;';
                                $btnClass = $phone ? 'bg-emerald-500 hover:bg-emerald-600 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed';
                            @endphp
                            <a href="{{ $waLink }}" target="{{ $phone ? '_blank' : '_self' }}" onclick="{{ $onClick }}" class="inline-flex items-center gap-2 px-4 py-2 {{ $btnClass }} rounded-xl font-medium text-sm transition shadow-sm" title="Hubungi via WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.201.535 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"></path></svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

@endif
@endsection
