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
<body class="snap-y snap-mandatory h-screen overflow-y-scroll pt-20">

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
  <section class="snap-start min-h-screen flex items-center justify-center bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-screen-xl mx-auto px-4 text-center fade-in fade-delay-2">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Your Schedule</h2>
      <p class="text-gray-600 dark:text-gray-300 mb-6">Lihat jadwal penanganan disini</p>
      <div class="w-full h-48 bg-blue-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-300">
        Jadwal belum tersedia
      </div>
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

</body>
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