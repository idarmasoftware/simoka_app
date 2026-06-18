<header class="fixed top-0 right-0 left-0 lg:left-72 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 h-[80px] px-4 sm:px-8 flex justify-between items-center shadow-sm">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <div class="hidden sm:block">
            <h1 class="text-xl font-semibold text-slate-800">@yield('page_title', 'Dashboard Perkembangan')</h1>
            <p class="text-slate-500 text-xs mt-0.5">Sistem informasi untuk monitoring perkembangan anak</p>
        </div>
    </div>

    <div class="flex items-center gap-3 sm:gap-5">
        @if(auth()->check() && !auth()->user()->isSuperAdmin())
        <!-- Notification Dropdown -->
        @php
            $mappedNotifs = auth()->user()->unreadNotifications->take(5)->map(function($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->data['title'] ?? 'Pemberitahuan',
                    'message' => $n->data['message'] ?? '',
                    'time' => $n->created_at->diffForHumans()
                ];
            })->values()->all();
        @endphp
        <div class="relative" x-data='{
            open: false,
            unreadCount: {{ auth()->user()->unreadNotifications->count() }},
            notifications: @json($mappedNotifs),
            init() {
                console.log("Alpine init for notifications");
                console.log("window.Echo available?", !!window.Echo);
                if (window.Echo) {
                    console.log("Subscribing to App.Models.User." + {{ auth()->id() }});
                    window.Echo.private("App.Models.User." + {{ auth()->id() }})
                        .notification((notification) => {
                            console.log("Received notification!", notification);
                            this.notifications.unshift({
                                id: notification.id,
                                title: notification.title || "Pemberitahuan Baru",
                                message: notification.message || "",
                                time: "Baru saja"
                            });
                            this.unreadCount++;
                            if (this.notifications.length > 5) this.notifications.pop();
                        });
                } else {
                    console.error("Echo is not loaded yet when Alpine started!");
                }
            },
            markAllAsRead() {
                if(this.unreadCount === 0) return;
                fetch("{{ route('notifications.mark-read') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" }
                }).then(() => {
                    this.unreadCount = 0;
                    this.notifications = [];
                });
            },
            markAsReadSingle(id) {
                fetch(`/notifications/${id}/mark-read`, {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" }
                }).then(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                    if (this.unreadCount > 0) this.unreadCount--;
                });
            }
        }' @click.outside="open = false">
            <button @click="open = !open" class="relative p-2 text-slate-500 hover:bg-slate-100 rounded-full transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span x-show="unreadCount > 0" x-text="unreadCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-rose-500 rounded-full"></span>
            </button>

            <div x-show="open" x-cloak
                 x-transition.opacity.duration.200ms
                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-sm">Notifikasi</h3>
                    <button @click.stop="markAllAsRead()" x-show="unreadCount > 0" class="text-[10px] font-semibold text-blue-600 hover:text-blue-800 transition bg-blue-50 px-2 py-1 rounded-full">
                        Tandai sudah dibaca
                    </button>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    <template x-if="notifications.length > 0">
                        <div class="divide-y divide-slate-50">
                            <template x-for="notif in notifications" :key="notif.id">
                                <div class="p-4 hover:bg-slate-50 transition cursor-pointer flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800 mb-0.5" x-text="notif.title"></p>
                                        <p class="text-xs text-slate-600 mb-1" x-text="notif.message"></p>
                                        <p class="text-[10px] text-slate-400" x-text="notif.time"></p>
                                    </div>
                                    <button @click.stop="markAsReadSingle(notif.id)" title="Tandai dibaca" class="text-slate-300 hover:text-blue-600 p-1 rounded-md hover:bg-blue-50 transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="notifications.length === 0">
                        <div class="p-6 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-2 text-slate-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-xs text-slate-500">Belum ada notifikasi baru</p>
                        </div>
                    </template>
                </div>
                <div class="px-4 py-3 border-t border-slate-100 bg-slate-50 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        Lihat Semua Notifikasi &rarr;
                    </a>
                </div>
            </div>
        </div>
        @endif

        <button class="flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-200 px-3 py-2 sm:px-4 rounded-lg font-medium hover:bg-blue-100 transition text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="hidden sm:inline">Mode {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->isTerapis() ? 'Terapis' : 'Orang Tua') }}</span>
        </button>

        <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

        <div class="relative" x-on:click.outside="profileOpen = false">
            <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 focus:outline-none cursor-pointer group hover:bg-slate-50 p-1.5 -m-1.5 rounded-xl transition-all">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center ring-2 ring-white shadow-md group-hover:ring-blue-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->isTerapis() ? 'Terapis' : 'Orang Tua') }}
                    </p>
                </div>
                <svg :class="profileOpen ? 'rotate-180 text-blue-500' : 'text-slate-400'"
                     class="w-4 h-4 transition-transform duration-200 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="profileOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">

                <div class="px-4 py-3 border-b border-slate-100 md:hidden">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">
                        {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->isTerapis() ? 'Terapis' : 'Orang Tua') }}
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Saya
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
                <div class="h-px bg-slate-100 my-2"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
