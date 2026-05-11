@extends('layouts.app')

@section('title', 'Dashboard Terapis - SI-MOKA')
@section('page_title', 'Dashboard Perkembangan')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, ROSSY PUTRI UTAMI, S.Tr.Kes</h2>
    <p class="text-slate-500 mt-1">Dashboard Terapis Okupasi</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center">
        <div>
            <p class="text-slate-500 text-sm font-medium mb-1">Total Pasien</p>
            <h3 class="text-3xl font-bold text-slate-800">24</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center">
        <div>
            <p class="text-slate-500 text-sm font-medium mb-1">Assessment Pending</p>
            <h3 class="text-3xl font-bold text-slate-800">5</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-yellow-400 text-white flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
    </div>
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center">
        <div>
            <p class="text-slate-500 text-sm font-medium mb-1">Langkah Menunggu Review</p>
            <h3 class="text-3xl font-bold text-slate-800">3</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-center">
        <div>
            <p class="text-slate-500 text-sm font-medium mb-1">Assessment Selesai Bulan Ini</p>
            <h3 class="text-3xl font-bold text-slate-800">12</h3>
        </div>
        <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
    <div class="bg-[#F0F7FF] border border-[#D6E8FF] p-6 rounded-2xl flex flex-col justify-between">
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
                Isi assessment berbasis kuesioner SSP untuk evaluasi sensory processing anak
            </p>
        </div>
        <div class="flex items-center justify-between mt-auto">
            <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full border border-yellow-200">3 Pending</span>
            <a href="#" class="text-blue-600 font-semibold hover:text-blue-700 text-sm flex items-center gap-1 transition">
                Mulai &rarr;
            </a>
        </div>
    </div>

    <div class="bg-[#F8F5FF] border border-[#E9D5FF] p-6 rounded-2xl flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-purple-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-800">Kelola Tugas Rumah</h3>
                    <p class="text-purple-600 font-medium text-xs sm:text-sm">Assign Aktivitas Terapi</p>
                </div>
            </div>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Buat dan assign tugas rumah berdasarkan hasil assessment SSP
            </p>
        </div>
        <div class="flex items-center justify-between mt-auto">
            <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full border border-purple-200">7 Kategori</span>
            <a href="#" class="text-purple-600 font-semibold hover:text-purple-700 text-sm flex items-center gap-1 transition">
                Buat Tugas &rarr;
            </a>
        </div>
    </div>

    <div class="bg-[#FFF8F0] border border-[#FFEDD5] p-6 rounded-2xl flex flex-col justify-between">
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
                Review dan approve langkah-langkah tugas yang disubmit orang tua
            </p>
        </div>
        <div class="flex items-center justify-between mt-auto">
            <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full border border-orange-200">3 Langkah Pending</span>
            <a href="#" class="text-orange-600 font-semibold hover:text-orange-700 text-sm flex items-center gap-1 transition">
                Review &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
