@extends('frontend.layouts.app')

@section('extraCSS')
  <style>
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .fade-in.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
@endsection

@section('content')
<body class="snap-y snap-mandatory h-screen overflow-y-scroll pt-20">

  <section class="snap-start min-h-screen bg-gradient-to-br 
                   from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 
                   flex items-center justify-center transition-colors duration-300">
    <div class="max-w-3xl w-full px-6 text-center fade-in">

      <h2 class="text-4xl font-extrabold text-white mb-6">
        Rekomendasi Penanganan
      </h2>

      <p class="text-lg text-white mb-2">
        Berdasarkan diagnosa, ikan terdeteksi mengalami:
      </p>

      <h3 class="text-3xl font-bold text-yellow-300 mb-8 capitalize animate-pulse">
        {{ $disease ?? 'Tidak diketahui' }}
      </h3>
      
      <div class="bg-white dark:bg-gray-100 text-gray-800 rounded-2xl shadow-2xl p-8 text-left leading-relaxed border-l-4 border-yellow-300">
        <div class="flex items-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
          </svg>
          <span class="font-semibold">Langkah penanganan:</span>
        </div>
        <p class="text-base">
          {!! nl2br(e($recommendation ?? 'Belum ada rekomendasi.')) !!}
        </p>
      </div>

      <div class="mt-10">
        <a href="{{ route('diagnosis.form') }}"
          class="inline-block bg-yellow-300 text-blue-900 font-semibold px-8 py-3 rounded-full shadow-lg hover:scale-105 hover:bg-yellow-400 transition transform duration-300">
          🔄 Diagnosa Ulang
        </a>
      </div>

    </div>
  </section>

</body>
@endsection

@section('extraJS')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const faders = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    faders.forEach(el => observer.observe(el));
  });
</script>
@endsection