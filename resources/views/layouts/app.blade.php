<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('simonita.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        /* Smooth scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased">
    <div x-data="{ sidebarOpen: false, profileOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden">
    </div>

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <div class="lg:ml-72 flex flex-col min-h-screen">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Main Content -->
        <main class="flex-1 mt-[80px] p-4 sm:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>
</div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReminder(formId) {
            Swal.fire({
                title: 'Kirim Pengingat?',
                text: "Notifikasi akan dikirimkan ke orang tua untuk mengingatkan tugas ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#9333ea', // purple-600
                cancelButtonColor: '#94a3b8', // slate-400
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    @stack('scripts')
</body>
</html>
