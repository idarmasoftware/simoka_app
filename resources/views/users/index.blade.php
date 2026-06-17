@extends('layouts.app')

@section('title', 'Manajemen User - SI-MOKA')
@section('page_title', 'Manajemen User')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Pengguna</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola data administrator, terapis, dan orang tua pasien.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('users.create') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold transition shadow-lg shadow-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah User
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col lg:flex-row flex-wrap items-center gap-4">
            <div class="w-full lg:flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, atau email..." autocomplete="off" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            @if(auth()->user()->isSuperAdmin())
            <div class="w-full lg:w-48">
                <select name="role" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                    <option value="">Semua Role</option>
                    <option value="terapis" {{ request('role') == 'terapis' ? 'selected' : '' }}>Terapis</option>
                    <option value="orang_tua" {{ request('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                </select>
            </div>
            @endif
            <div>
                <button type="submit" class="w-full sm:w-auto bg-blue-50 text-blue-600 hover:bg-blue-100 px-6 py-2 rounded-xl font-medium transition text-sm">Cari</button>
            </div>
            @if(request()->hasAny(['search', 'role']))
            <div>
                <a href="{{ route('users.index') }}" class="flex items-center justify-center w-full sm:w-auto bg-slate-50 text-slate-500 hover:bg-slate-100 px-4 py-2 rounded-xl font-medium transition text-sm">Reset</a>
            </div>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ '@' . $user->username }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm text-slate-700 font-medium">{{ $user->email }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $user->phone_number ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $roleColors = [
                                    'super_admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                    'terapis' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'orang_tua' => 'bg-amber-50 text-amber-600 border-amber-100',
                                ];
                                $roleLabels = [
                                    'super_admin' => 'Super Admin',
                                    'terapis' => 'Terapis',
                                    'orang_tua' => 'Orang Tua',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $roleColors[$user->role] }}">
                                {{ $roleLabels[$user->role] }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @if($user->is_active)
                                <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-slate-400 text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    Non-aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Ubah">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada data user.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
