@extends('layouts.guest')

@section('content')
<section class="py-16 bg-gray-50 fade-in fade-delay-2">
  <div class="max-w-screen-md mx-auto px-4 text-center">
    <h1 class="text-2xl font-bold mb-4">Verifikasi Email Anda</h1>
    <p class="mb-6">Kami telah mengirim link verifikasi ke <strong>{{ auth()->user()->email }}</strong>.  
       Silakan cek inbox atau folder spam Anda.</p>

    @if (session('status') == 'verification-link-sent')
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        Link verifikasi baru telah dikirim ke email Anda.
      </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg">
        Kirim Ulang Link Verifikasi
      </button>
    </form>
  </div>
</section>
@endsection
