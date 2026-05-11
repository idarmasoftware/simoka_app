<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-MOKA | Sistem Informasi Monitoring Terapi Okupasi Anak</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        S
                    </div>
                    <span class="font-bold text-xl tracking-tight text-blue-900">SI-MOKA</span>
                </div>
                <div class="flex space-x-4 items-center">
                    <a href="#" class="text-slate-600 hover:text-blue-600 font-medium px-3 py-2 transition">Masuk</a>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-full transition shadow-md">Daftar Orang Tua</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-40 flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 text-center lg:text-left z-10">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 font-semibold text-sm mb-4 border border-blue-100">
                    Sistem Pemantauan Terapi Pediatrik
                </span>
                <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight mb-6">
                    Pantau Tumbuh Kembang Anak Lebih Mudah & Terarah
                </h1>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    SI-MOKA membantu orang tua dan terapis berkolaborasi mendigitalkan evaluasi sensori (Short Sensory Profile) dan memantau riwayat terapi anak secara terpadu.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition shadow-lg text-center">
                        Mulai Daftar Sekarang
                    </a>
                    <a href="#fitur" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold px-8 py-3 rounded-full transition shadow-sm text-center">
                        Pelajari Fitur
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 relative z-10 flex justify-center">
                <div class="w-full max-w-md aspect-square bg-gradient-to-tr from-blue-100 to-indigo-50 rounded-full flex items-center justify-center p-8 shadow-inner border border-white">
                    <div class="bg-white p-6 rounded-2xl shadow-xl w-full text-center">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📊</div>
                        <h3 class="font-bold text-slate-800 mb-2">Short Sensory Profile</h3>
                        <p class="text-sm text-slate-500 mb-4">Skoring dan klasifikasi otomatis dalam hitungan detik.</p>
                        <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Mengapa Menggunakan SI-MOKA?</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Kami merancang sistem ini untuk mempermudah alur komunikasi antara klinik, terapis, dan orang tua pasien.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl mb-6">👨‍👩‍👧‍👦</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Satu Akun, Banyak Anak</h3>
                    <p class="text-slate-600 leading-relaxed">Orang tua cukup menggunakan satu akun email untuk memantau jadwal dan riwayat rekam medis seluruh buah hatinya.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xl mb-6">📝</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Asesmen Digital Otomatis</h3>
                    <p class="text-slate-600 leading-relaxed">Tinggalkan kertas manual. Pengisian form evaluasi dan perhitungan klasifikasi berjalan otomatis.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center text-xl mb-6">📈</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Grafik Perkembangan Interaktif</h3>
                    <p class="text-slate-600 leading-relaxed">Lihat kemajuan anak melalui grafik radar dan garis yang mudah dipahami oleh orang tua maupun terapis.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-xs">S</div>
                <span class="font-semibold text-slate-800">SI-MOKA</span>
            </div>
            <p class="text-slate-500 text-sm">© {{ date('Y') }} Sistem Informasi Monitoring Terapi Okupasi Anak. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
