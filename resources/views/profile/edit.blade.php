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
  
  .tooltip {
    @apply invisible absolute;
    opacity: 0;
    transition: 0.3s ease-in-out;
  }
  
  .has-tooltip:hover .tooltip {
    @apply visible;
    opacity: 1;
  }

  .input-field:focus-within {
    @apply ring-2 ring-blue-500 ring-opacity-50;
    transform: translateY(-1px);
  }

  .form-section {
    @apply bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mb-6;
  }
</style>
@endsection

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

<!-- Breadcrumb -->
<nav class="bg-white dark:bg-gray-800 shadow-sm">
  <div class="max-w-screen-md mx-auto px-4 py-3">
    <div class="flex items-center space-x-2 text-sm">
      <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
      <span class="text-gray-500">/</span>
      <a href="{{ route('profile.show') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Profile</a>
      <span class="text-gray-500">/</span>
      <span class="text-gray-600 dark:text-gray-400">Edit</span>
    </div>
  </div>
</nav>

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

<section class="py-16 fade-in fade-delay-2">
  <div class="max-w-screen-md mx-auto px-4">
    
    <!-- Only show profile update message if profile data was changed -->
    @if (session('status') === 'profile-updated' && $errors->isEmpty() && 
         (old('name') !== $user->name || old('email') !== $user->email))
      <div class="mb-6 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-lg flex items-center justify-between animate-fade-in">
        <div class="flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
          </svg>
          <span>{{ __('Perubahan Berhasil Disimpan.') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-300 hover:text-green-900">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
      @csrf
      @method('patch')

      <!-- Profile Information Section -->
      <div class="form-section">
        <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">Informasi Profil</h2>
        <div class="space-y-6">
          <!-- Name Field -->
          <div class="input-field transition-all duration-200">
            <label for="name" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
              Nama Lengkap
              <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input id="name" name="name" type="text"
                class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none"
                value="{{ old('name', $user->name) }}" required autofocus />
              <div class="tooltip bg-gray-900 text-white text-sm rounded py-1 px-2 -mt-2 absolute top-0 right-0">
                Nama yang akan ditampilkan di profil Anda
              </div>
            </div>
            @error('name')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email Field -->
          <div class="input-field transition-all duration-200">
            <label for="email" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
              Alamat Email
              <span class="text-red-500">*</span>
            </label>
            <input id="email" name="email" type="email"
              class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none"
              value="{{ old('email', $user->email) }}" required />
            @error('email')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Password Section -->
      <div class="form-section">
        <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Ubah Password</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Kosongkan bidang ini jika Anda tidak ingin mengubah password</p>
        
        <div class="space-y-6">
          <!-- Current Password -->
          <div class="input-field transition-all duration-200">
            <label for="current_password" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
              Password Saat Ini
            </label>
            <input id="current_password" name="current_password" type="password"
              class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none
              @error('current_password', 'updatePassword') border-red-500 @enderror"
              autocomplete="current-password" />
            @error('current_password', 'updatePassword')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- New Password -->
          <div class="input-field transition-all duration-200">
            <label for="password" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
              Password Baru
            </label>
            <input id="password" name="password" type="password"
              class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none
              @error('password', 'updatePassword') border-red-500 @enderror"
              autocomplete="new-password" />
            @error('password', 'updatePassword')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div class="input-field transition-all duration-200">
            <label for="password_confirmation" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
              Konfirmasi Password Baru
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
              class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:outline-none
              @error('password_confirmation', 'updatePassword') border-red-500 @enderror"
              autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end gap-4">
        <a href="{{ route('profile.show') }}" 
          class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-200">
          Batal
        </a>
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
          {{ __('Simpan Perubahan') }}
        </button>
      </div>
      @if (session('status') === 'password-updated' && $errors->updatePassword->isEmpty() && session()->has('current_password'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-lg flex items-center justify-between animate-fade-in">
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
            </svg>
            <span>{{ __('Password berhasil diperbarui.') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-300 hover:text-green-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      @endif
    </form>
  </div>
</section>
</div>
@endsection
