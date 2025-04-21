@extends('frontend.layouts.app')

@section('extraCSS')
<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .fade-in { opacity: 0; animation: fadeIn 1s ease-in-out forwards; }
  .fade-delay-1 { animation-delay: 0.3s; }
  .fade-delay-2 { animation-delay: 0.6s; }
  .fade-delay-3 { animation-delay: 0.9s; }
</style>
@endsection

@section('content')
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

<!-- Hero Section -->
<section class="snap-start bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center relative">
  <div class="absolute inset-0">
    <img src="/assets/hero/wave.svg" class="w-full h-full object-cover opacity-30" alt="Wave background">
    <div class="absolute top-20 left-16 w-20 h-20 rounded-full bg-blue-700 dark:bg-gray-700 opacity-20 animate-pulse"></div>
    <div class="absolute bottom-16 right-20 w-32 h-32 rounded-full bg-blue-500 dark:bg-gray-600 opacity-15 animate-pulse"></div>
  </div>
  <div class="relative max-w-screen-md mx-auto px-4 text-center flex flex-col items-center justify-center min-h-[60vh]">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4 text-white">Edit Akun</h1>
    <p class="mb-8 max-w-xl mx-auto text-white">Kelola informasi akun Anda di sini, seperti nama, email, dan password.</p>
  </div>
</section>

<!-- Profile + Password Form -->
<section class="py-16 fade-in fade-delay-2 bg-white dark:bg-gray-900">
  <div class="max-w-screen-md mx-auto px-4 space-y-8">

    @if (session('status') === 'profile-updated')
      <div class="p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-lg">
        {{ __('Perubahan Berhasil Disimpan.') }}
      </div>
    @endif

    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
      <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
          <label for="name" class="block font-medium mb-1">{{ __('Name') }}</label>
          <input id="name" name="name" type="text"
            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ old('name', $user->name) }}" required autofocus />
          @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block font-medium mb-1">{{ __('Email') }}</label>
          <input id="email" name="email" type="email"
            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ old('email', $user->email) }}" required />
          @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Lama -->
        <div>
          <label for="current_password" class="block font-medium mb-1">{{ __('Current Password') }}</label>
          <input id="current_password" name="current_password" type="password"
            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            autocomplete="current-password" />
          @error('current_password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Baru -->
        <div>
          <label for="password" class="block font-medium mb-1">{{ __('New Password') }}</label>
          <input id="password" name="password" type="password"
            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            autocomplete="new-password" />
          @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation" class="block font-medium mb-1">{{ __('Confirm Password') }}</label>
          <input id="password_confirmation" name="password_confirmation" type="password"
            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            autocomplete="new-password" />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg transition transform hover:scale-105">
            {{ __('Simpan Perubahan') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
</body>
@endsection
