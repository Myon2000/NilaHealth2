<nav class="fixed top-0 left-0 w-full flex justify-between items-center px-4 py-3 bg-[#003366] dark:bg-gray-900 text-white transition-colors shadow-lg z-50">
  <!-- Logo -->
  <div class="flex items-center space-x-2">
    <img src="{{ asset('assets/logo.png') }}" class="h-8 w-8" alt="Logo">
    <a class="font-bold text-base" href="{{ route('home') }}">NilaHealth</a>
  </div>

  <!-- Navigation Links (Desktop) -->
  <div class="hidden md:flex items-center space-x-8">
    <a href="{{ route('diagnosis.form') }}" class="hover:text-blue-400 transition">Diagnosis</a>
    <a href="#schedule" class="hover:text-blue-400 transition">Schedule</a>
    <a href="{{ route('home') }}#article" class="hover:text-blue-400 transition">Article</a>

    <!-- Profile Dropdown -->
    <div class="relative" x-data="{ open: false }">
      <button @click="open = !open" @click.away="open = false"
              class="flex items-center hover:text-blue-400 transition">
        <span class="mr-1">Profile</span>
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 
                   111.06 1.06l-4.24 4.25a.75.75 0 
                   01-1.06 0L5.21 8.29a.75.75 0 
                   01.02-1.08z"
                clip-rule="evenodd"/>
        </svg>
      </button>
      <div x-show="open" x-transition
           class="absolute right-0 mt-2 w-44 bg-white text-black rounded shadow-md z-50">
        <a href="{{ route('profile.show') }}"
           class="block px-4 py-2 hover:bg-gray-100">Informasi Akun</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
        </form>
      </div>
    </div>

    <!-- Theme Toggle -->
    <button id="theme-toggle"
            class="p-2 rounded-full border border-yellow-400 hover:bg-yellow-400 hover:text-gray-900 transition duration-300 ease-in-out">
      <svg id="theme-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path d="M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m16.364 
                 6.364l-.707-.707M12 21v-1M6.343 
                 17.657l-.707-.707M5 5l14 14"/>
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div class="md:hidden relative" x-data="{ open: false }">
    <button @click="open = !open"
            class="focus:outline-none p-2 rounded hover:bg-white/10 transition">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path :class="{ 'hidden': open }" d="M4 6h16M4 12h16M4 18h16"/>
        <path :class="{ 'hidden': !open }" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    <div x-show="open" x-transition
         class="absolute right-0 top-14 w-52 bg-white text-black rounded shadow-lg z-50 p-2 space-y-2">
      <a href="{{ route('diagnosis.form') }}"
         class="block px-4 py-2 rounded hover:bg-gray-100">Diagnosis</a>
      <a href="#schedule"
         class="block px-4 py-2 rounded hover:bg-gray-100">Schedule</a>
      <a href="{{ route('home') }}#schedule"
         class="block px-4 py-2 rounded hover:bg-gray-100">Schedule Sect.</a>
      <a href="{{ route('home') }}#article"
         class="block px-4 py-2 rounded hover:bg-gray-100">Article</a>
      <a href="{{ route('profile.show') }}"
         class="block px-4 py-2 rounded hover:bg-gray-100">Informasi Akun</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="w-full text-left px-4 py-2 rounded hover:bg-gray-100">Logout</button>
      </form>
      <button id="theme-toggle-mobile"
              class="w-full flex justify-center p-2 rounded-full border border-yellow-400 hover:bg-yellow-400 hover:text-gray-900 transition duration-300 ease-in-out">
        <svg id="theme-icon-mobile" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path d="M12 3v1m6.364 1.636l-.707.707M21 
                   12h-1M4 12H3m16.364 6.364l-.707-.707M12 
                   21v-1M6.343 17.657l-.707-.707M5 5l14 14"/>
        </svg>
      </button>
    </div>
  </div>
</nav>
