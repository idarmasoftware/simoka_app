@extends('layouts.app')

@section('title', 'Tambah User - SI-MOKA')
@section('page_title', 'Tambah User')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-100 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Tambah User Baru</h2>
            <p class="text-slate-500 text-sm">Pastikan data yang dimasukkan sudah benar.</p>
        </div>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="Masukkan nama lengkap" required>
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="text-sm font-bold text-slate-700">Role User</label>
                    <select name="role" id="role"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 appearance-none">
                        <option value="orang_tua" {{ old('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="terapis" {{ old('role') == 'terapis' ? 'selected' : '' }}>Terapis</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-slate-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="contoh@email.com" required>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- No. Telepon -->
                <div class="space-y-2">
                    <label for="phone_number" class="text-sm font-bold text-slate-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="0812xxxxxxxx">
                    @error('phone_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="h-px bg-slate-100 my-4"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="text-sm font-bold text-slate-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="username_login" required>
                    @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="••••••••" required>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-bold text-slate-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700"
                           placeholder="••••••••" required>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('users.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-800 transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-bold transition shadow-lg shadow-blue-200 active:scale-95">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection
