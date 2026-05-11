<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Orang Tua - SI-MOKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-6 py-12">
    <div class="max-w-2xl w-full">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-600 rounded-2xl shadow-xl shadow-blue-200 mb-4">
                <span class="text-white text-xl font-extrabold tracking-tighter">SM</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">SI-MOKA</h1>
            <p class="text-slate-500 mt-1">Registrasi Akun Orang Tua Pasien</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/50 p-8 sm:p-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-2">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Daftar Akun Baru</h2>
                    <p class="text-slate-500 text-sm">Lengkapi data diri Anda untuk memulai.</p>
                </div>
                <div class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-bold border border-amber-100">
                    KHUSUS ORANG TUA
                </div>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="space-y-2">
                        <label for="name" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="Nama lengkap Anda" required>
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="email@contoh.com" required>
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone_number" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nomor WhatsApp</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="0812xxxxxxxx" required>
                        @error('phone_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label for="username" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="username_login" required>
                        @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="••••••••" required>
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-700 font-medium"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl flex gap-3 items-start">
                    <input type="checkbox" id="terms" required class="mt-1 w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="terms" class="text-xs text-blue-800 leading-relaxed">
                        Saya menyetujui <a href="#" class="font-bold underline">Syarat dan Ketentuan</a> penggunaan SI-MOKA untuk pemantauan perkembangan anak saya secara mandiri atau dengan bantuan terapis.
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-blue-200 transition-all active:scale-95">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
