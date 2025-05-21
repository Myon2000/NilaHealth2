@component('mail::message')
# Pengingat Jadwal

Halo {{ $jadwal->user->name }},

Ini adalah pengingat untuk jadwal Anda:

**{{ $jadwal->keterangan }}**
Tanggal: {{ $jadwal->tanggal->format('d M Y') }}
Waktu: {{ $jadwal->waktu->format('H:i') }}

@if($jadwal->recurrence_type !== 'once')
Pengulangan: {{ $jadwal->recurrence_type === 'daily' ? 'Setiap Hari' : 'Kustom' }}
@endif

@component('mail::button', ['url' => route('home')])
Lihat Jadwal
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent