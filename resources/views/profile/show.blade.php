@extends('frontend.layouts.app')

@section('extraCSS')
<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .fade-in {
    opacity: 0;
    animation: fadeIn 1s ease-in-out forwards;
  }
  .fade-delay-1 { animation-delay: 0.3s; }
  .fade-delay-2 { animation-delay: 0.6s; }
  .fade-delay-3 { animation-delay: 0.9s; }
</style>
@endsection

@section('content')
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300 overflow-hidden">

<div class="min-h-screen flex flex-col justify-between">

  <!-- Profile Info Hero Section -->
  <section class="flex-[2] bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center relative">
    <div class="absolute inset-0">
      <img src="/assets/hero/wave.svg" class="w-full h-full object-cover opacity-30" alt="Wave background">
      <div class="absolute top-20 left-16 w-20 h-20 rounded-full bg-blue-700 dark:bg-gray-700 opacity-20 animate-pulse"></div>
      <div class="absolute bottom-16 right-20 w-32 h-32 rounded-full bg-blue-500 dark:bg-gray-600 opacity-15 animate-pulse"></div>
    </div>
    <div class="relative max-w-screen-md mx-auto px-4 text-center">
      <h1 class="text-4xl sm:text-5xl font-bold mb-4 text-white">Informasi Akun</h1>
      <p class="mb-8 max-w-xl mx-auto text-white">Berikut adalah detail akun Anda.</p>
      <div class="flex justify-center space-x-4">
        <a href="{{ route('profile.edit') }}" 
          class="btn-shine inline-block bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold px-8 py-3 rounded-full shadow-lg transition transform hover:scale-105">
          Edit Akun
        </a>
      </div>
    </div>
  </section>

  <!-- Profile Info Display Section -->
  <section class="flex-[1] flex items-center justify-center fade-in fade-delay-2 bg-white dark:bg-gray-900">
    <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-2xl mx-auto space-y-6">
      <h2 class="text-2xl font-semibold mb-4 border-b pb-2 dark:border-gray-700">Detail Pengguna</h2>
      <div class="space-y-4">
        <div class="flex justify-between items-center">
          <span class="font-medium">Nama:</span>
          <span>{{ $user->name }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="font-medium">Email:</span>
          <span>{{ $user->email }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="font-medium">Tanggal Bergabung:</span>
          <span>{{ $user->created_at->format('d M Y') }}</span>
        </div>
      </div>
    </div>
  </section>

</div>

</body>
@endsection