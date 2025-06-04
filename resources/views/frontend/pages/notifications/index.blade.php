@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Notifikasi</h1>
        @if($notifications->where('is_read', false)->count() > 0)
            <button onclick="markAllAsRead()" class="text-blue-600 hover:text-blue-800">
                Tandai semua sudah dibaca
            </button>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 {{ !$notification->is_read ? 'border-l-4 border-blue-500' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-gray-800 dark:text-white">{{ $notification->message }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notification->is_read)
                        <button onclick="markAsRead({{ $notification->id }})" class="text-sm text-blue-600 hover:text-blue-800">
                            Tandai sudah dibaca
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                Tidak ada notifikasi
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('extraJS')
<script>
async function markAsRead(id) {
    try {
        const res = await fetch(`{{ url('/notifications') }}/${id}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal menandai notifikasi');
        window.notify.success(data.message);
        const elem = event.target.closest('div.rounded-lg');
        elem.classList.remove('border-l-4', 'border-blue-500');
        event.target.remove();
    } catch (e) {
        console.error(e);
        window.notify.error(e.message);
    }
}

async function markAllAsRead() {
    try {
        const res = await fetch('{{ url('/notifications/mark-all-as-read') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal menandai semua notifikasi');
        window.notify.success(data.message);
        setTimeout(() => location.reload(), 500);
    } catch (e) {
        console.error(e);
        window.notify.error(e.message);
    }
}
</script>
@endsection
