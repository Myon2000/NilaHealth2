@extends('frontend.layouts.app')

@section('extraCSS')
  <style>
    @keyframes fadeSlideUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-in.is-visible {
      opacity: 1;
      transform: translateY(0);
    }

    .hero-fade {
      opacity: 0;
      animation: fadeSlideUp 1s ease forwards;
    }

    .delay-1 { animation-delay: 0.3s; }
    .delay-2 { animation-delay: 0.6s; }
    .delay-3 { animation-delay: 0.9s; }
  </style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="snap-start min-h-screen bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center relative transition-colors duration-300">
    <div class="absolute inset-0">
      <img src="/assets/hero/wave.svg" class="w-full h-full object-cover opacity-30" alt="Wave background">
      <div class="absolute top-20 left-16 w-40 h-40 rounded-full bg-blue-700 dark:bg-gray-700 opacity-20 animate-pulse"></div>
      <div class="absolute bottom-16 right-20 w-52 h-52 rounded-full bg-blue-500 dark:bg-gray-600 opacity-15 animate-pulse"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto w-full px-4 text-center">
      <h1 class="text-white text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-6 hero-fade delay-1">
        Solusi Cerdas untuk Nila Sehat
      </h1>
      <p class="text-white text-lg sm:text-xl max-w-3xl mx-auto mb-10 hero-fade delay-2">
        NilaHealth adalah platform cerdas yang membantu petani ikan dalam mendeteksi penyakit, 
        menganalisis kondisi ikan nila, dan mengelola kesehatan kolam secara efisien.
      </p>
      <a href="{{ route('diagnosis.form') }}" 
        class="btn-shine inline-block bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 
                font-semibold px-8 py-3 rounded-full shadow-lg transition transform hero-fade delay-3">
          Try Out Now
      </a>
    </div>  
  </section>

<!-- Schedule Section -->
<!-- Schedule Section -->
<section id="schedule" class="snap-start min-h-screen flex items-center justify-center bg-gradient-to-b from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
    <div class="max-w-screen-xl mx-auto px-4 py-16 text-center fade-in fade-delay-2">
        <!-- Section Header -->
        <div class="mb-12">
            <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold tracking-wider uppercase">Pengingat Penanganan</span>
            <h2 class="text-4xl font-bold text-gray-800 dark:text-white mt-2 mb-4">Jadwal Penanganan</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-300 text-lg max-w-2xl mx-auto">
                Kelola jadwal penanganan ikan nila Anda dengan mudah dan terorganisir
            </p>
        </div>
        
        @if($schedules && $schedules->count() > 0)
            <!-- Schedule Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $jadwal)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl p-6 transform hover:-translate-y-2 transition-all duration-300 border border-gray-100 dark:border-gray-700">
                        <!-- Date and Time Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full px-4 py-2">
                                <span class="text-blue-800 dark:text-blue-200 text-sm font-medium">
                                    {{ $jadwal->tanggal->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400 font-medium">
                                    {{ $jadwal->waktu->format('H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">
                            {{ $jadwal->keterangan }}
                        </h3>
                        
                        <!-- Details -->
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">
                                    @if($jadwal->recurrence_type === 'once')
                                        Sekali
                                    @elseif($jadwal->recurrence_type === 'daily')
                                        Setiap Hari
                                    @else
                                        {{ implode(', ', $jadwal->recurrence_days) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="text-blue-600 dark:text-blue-400 font-medium">
                                    {{ $jadwal->remind_before }} menit sebelumnya
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Button -->
            <div class="mt-12">
                <a href="{{ route('jadwal.index') }}" 
                   class="inline-flex items-center px-8 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 group">
                    <span>Lihat Semua Jadwal</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 max-w-md mx-auto border border-gray-100 dark:border-gray-700">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak ada jadwal</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Mulai buat jadwal penanganan untuk memantau kesehatan ikan nila Anda.
                    </p>
                    <a href="{{ route('jadwal.index') }}" 
                       class="inline-flex items-center px-6 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 group">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Tambah Jadwal</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

  <!-- Blog Preview Section -->
  <section class="snap-start min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-950 transition-colors duration-300">
    <div class="max-w-screen-xl mx-auto px-4 fade-in fade-delay-3">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-white text-center mb-4">Blog</h2>
      <p class="text-center text-gray-600 dark:text-gray-300 mb-10">
        Cari tahu berbagai informasi, tips, dan trik menarik seputar budidaya ikan.
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
          <img src="/images/blog1.jpg" alt="Blog 1" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-white">
              Antara Kontroversi dan Inovasi dalam AI Art
            </h3>
            <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4">
              Fenomena mengubah foto jadi ilustrasi bergaya art menggunakan AI semakin populer...
            </p>
            <a href="#" class="text-blue-500 dark:text-blue-400 font-medium hover:underline">Read more →</a>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
          <img src="/images/blog2.jpg" alt="Blog 2" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-white">
              Kamu Anak IT? Yuk Bangun Personal Branding!
            </h3>
            <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4">
              Pernah mikir kenapa orang dengan skill IT mudah dapat peluang kerja dan magang?
            </p>
            <a href="#" class="text-blue-500 dark:text-blue-400 font-medium hover:underline">Read more →</a>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
          <img src="/images/blog3.jpg" alt="Blog 3" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-white">
              AI dan Masa Depan Pekerja Industri
            </h3>
            <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4">
              Bagaimana AI merubah proses manufaktur dan apa artinya bagi tenaga kerja?
            </p>
            <a href="#" class="text-blue-500 dark:text-blue-400 font-medium hover:underline">Read more →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('extraJS')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const faders = document.querySelectorAll('.fade-in');

    const appearOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -100px 0px"
    };

    const appearOnScroll = new IntersectionObserver(function (entries, observer) {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    }, appearOptions);

    faders.forEach(fadeEl => {
      appearOnScroll.observe(fadeEl);
    });
  });
</script>
@endsection