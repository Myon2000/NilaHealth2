@extends('layouts.guest')

@section('extraCSS')
<style>
  @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
  .fade-in { opacity: 0; animation: fadeIn 1s ease-in-out forwards; }
  .fade-delay-1 { animation-delay: 0.3s; }
  .fade-delay-2 { animation-delay: 0.6s; }
</style>
@endsection

@section('content')
<section class="relative pt-16 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white fade-in fade-delay-1">
  <div class="absolute inset-0 overflow-hidden">
    <img src="/assets/hero/wave.svg" class="w-full h-full object-cover opacity-30" alt="Wave background">
  </div>
  <div class="relative max-w-screen-xl mx-auto px-4 py-28 text-center">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4">Reset Password</h1>
    <p class="mb-8 max-w-2xl mx-auto">Masukkan email Anda, kami akan kirim link untuk mengubah password.</p>
  </div>
</section>

<section class="py-16 bg-white fade-in fade-delay-2">
  <div class="max-w-md mx-auto px-4">
    @if (session('status'))
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('status') }}
      </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-lg">
      <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
          <label for="email" class="block text-gray-700 mb-1">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 required autofocus
                 class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          @error('email')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">
          Kirim Link Reset Password
        </button>
      </form>
      <p class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Kembali ke Login</a>
      </p>
    </div>
  </div>
</section>
@endsection