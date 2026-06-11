<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('simonita.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMONITA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 relative">
    <!-- Background Decoration -->
    <div class="fixed inset-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-blue-100/60 blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-[400px] h-[400px] rounded-full bg-indigo-50/60 blur-3xl"></div>
    </div>

    <div class="max-w-md w-full z-10">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <img src="{{ asset('simonita.svg') }}" alt="SIMONITA Logo" class="w-64 mx-auto">
        </div>

        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] border border-white shadow-2xl shadow-slate-200/50 p-8 sm:p-10">
            <h2 class="text-2xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
            <p class="text-slate-500 text-sm mb-8">Silakan masuk ke akun Anda untuk melanjutkan.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl mb-6 text-sm font-medium flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Username -->
                <div class="space-y-1.5">
                    <label for="username" class="text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-800 font-medium"
                               placeholder="Masukkan username" required autofocus autocomplete="off">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5" x-data="{ show: false }">
                    <div class="flex justify-between items-center ml-1">
                        <label for="password" class="text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                               class="w-full pl-11 pr-12 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-slate-800 font-medium"
                               placeholder="••••••••" required autocomplete="off">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500 transition-colors focus:outline-none">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 bg-slate-50 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600 font-medium cursor-pointer">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-2xl font-bold text-lg shadow-xl shadow-blue-600/20 transition-all active:scale-95 mt-4">
                    Masuk
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm font-medium">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">Daftar sebagai Orang Tua</a></p>
            </div>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-slate-400 text-xs font-medium mt-10">
            &copy; 2026 SIMONITA. Seluruh hak cipta dilindungi.
        </p>
    </div>
</body>
</html>
