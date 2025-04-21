@extends('layouts.guest')

@section('extraCSS')
<style>
  /* Custom fade-in animation */
  @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  .fade-in { opacity: 0; animation: fadeIn 1s ease-in-out forwards; }
  .fade-delay-1 { animation-delay: 0.3s; }
  .fade-delay-2 { animation-delay: 0.6s; }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative pt-16 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white fade-in fade-delay-1">
  <div class="absolute inset-0 overflow-hidden">
    <img src="/assets/hero/wave.svg" class="w-full h-full object-cover opacity-30" alt="Wave background">
    <div class="absolute top-16 left-16 w-40 h-40 rounded-full bg-blue-800 opacity-20 animate-pulse"></div>
    <div class="absolute bottom-16 right-20 w-52 h-52 rounded-full bg-blue-700 opacity-15 animate-pulse"></div>
  </div>
  <div class="relative max-w-screen-xl mx-auto px-4 py-28 text-center">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4">Buat Akun Baru</h1>
    <p class="mb-8 max-w-2xl mx-auto">Daftar sekarang untuk mengakses fitur lengkap NilaHealth.</p>
  </div>
</section>

<!-- Register Form Section -->
<!-- Register Form Section -->
<section class="py-16 bg-white fade-in fade-delay-2">
    <div class="max-w-md mx-auto px-4">
      <div class="bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register</h2>
  
        {{-- ALERT ERROR --}}
        @if ($errors->any())
          <div class="mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
              <strong class="font-bold">Pendaftaran gagal!</strong>
              <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
  
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
          @csrf
          <div>
            <label class="block text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label class="block text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105">Register</button>
        </form>
        <p class="mt-4 text-center text-gray-600">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
      </div>
    </div>
  </section>  
@endsection