@extends('layouts.app')

@section('title', 'Semua Notifikasi - SIMONITA')
@section('page_title', 'Semua Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Riwayat Notifikasi</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar semua pemberitahuan yang pernah Anda terima</p>
        </div>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
        <button onclick="markAllAsReadPage()" class="bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Tandai Semua Dibaca
        </button>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @forelse($notifications as $notif)
            <div class="p-5 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition {{ is_null($notif->read_at) ? 'bg-blue-50/30' : '' }}">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ is_null($notif->read_at) ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4 mb-1">
                            <h3 class="font-bold text-slate-800 {{ is_null($notif->read_at) ? 'text-blue-900' : '' }}">
                                {{ $notif->data['title'] ?? 'Pemberitahuan' }}
                            </h3>
                            <div class="flex items-center gap-3">
                                @if(is_null($notif->read_at))
                                <button onclick="markAsReadSinglePage('{{ $notif->id }}')" title="Tandai dibaca" class="text-slate-400 hover:text-blue-600 p-1.5 rounded-lg hover:bg-blue-100/50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                @endif
                                <span class="text-xs text-slate-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            {{ $notif->data['message'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-slate-500 font-bold mb-1">Belum Ada Notifikasi</h3>
                <p class="text-slate-400 text-sm">Anda belum menerima pemberitahuan apapun sejauh ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>

@push('scripts')
<script>
    function markAllAsReadPage() {
        fetch('{{ route('notifications.mark-read') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(() => {
            window.location.reload();
        });
    }

    function markAsReadSinglePage(id) {
        fetch(`/notifications/${id}/mark-read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(() => {
            window.location.reload();
        });
    }
</script>
@endpush
@endsection
