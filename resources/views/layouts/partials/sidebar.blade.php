<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col h-screen transform transition-transform duration-300 ease-in-out lg:translate-x-0">

    <div class="p-6 flex items-center justify-between border-b border-slate-100 h-[80px] flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">A</div>
            <div>
                <h1 class="font-bold text-slate-800 text-lg leading-tight">Dashboard</h1>
                <p class="text-xs text-slate-500">Assessment Anak</p>
            </div>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white shadow-sm shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 transition' }} px-4 py-3 rounded-xl font-medium">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Dashboard Terapis
        </a>

        <a href="#" class="flex items-center gap-3 text-slate-600 hover:bg-slate-50 px-4 py-3 rounded-xl font-medium transition">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Assessment SSP
        </a>
        <a href="#" class="flex items-center gap-3 text-slate-600 hover:bg-slate-50 px-4 py-3 rounded-xl font-medium transition">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Riwayat Assessment
        </a>
        <a href="#" class="flex items-center gap-3 text-slate-600 hover:bg-slate-50 px-4 py-3 rounded-xl font-medium transition">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            Kelola Tugas Rumah
        </a>
        <a href="#" class="flex items-center gap-3 text-slate-600 hover:bg-slate-50 px-4 py-3 rounded-xl font-medium transition">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Review Langkah Tugas
        </a>

        <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Manajemen</p>

        <a href="{{ route('children.index') }}" class="flex items-center gap-3 {{ request()->routeIs('children.*') ? 'bg-blue-500 text-white shadow-sm shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 transition' }} px-4 py-3 rounded-xl font-medium">
            <svg class="w-5 h-5 {{ request()->routeIs('children.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kelola Pasien
        </a>
        <a href="{{ route('users.index') }}" class="flex items-center gap-3 {{ request()->routeIs('users.*') ? 'bg-blue-500 text-white shadow-sm shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 transition' }} px-4 py-3 rounded-xl font-medium">
            <svg class="w-5 h-5 {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            Kelola Akun
        </a>
    </nav>
</aside>
