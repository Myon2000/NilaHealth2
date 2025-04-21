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

    .image-preview-wrapper {
      position: relative;
      display: inline-block;
    }

    .prediction-label {
      position: absolute;
      top: 10px;
      left: 10px;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1rem;
      z-index: 10;
    }
  </style>
@endsection

@section('content')
<body class="snap-y snap-mandatory h-screen overflow-y-scroll pt-20">

  <!-- Result Section -->
  <section class="snap-start min-h-screen bg-gradient-to-br 
                   from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 
                   flex items-center justify-center transition-colors duration-300">
    <div class="max-w-2xl w-full px-4 text-center fade-in">
      <h2 class="text-4xl font-extrabold text-white mb-6">Hasil Diagnosa</h2>

      @php $r = session('result'); @endphp

      @if($r)
        <div class="image-preview-wrapper mb-6">
          @if(!empty($r['predicted_image_url']))
            <img src="{{ $r['predicted_image_url'] }}" 
                 alt="Hasil Prediksi"
                 class="rounded-lg shadow-lg w-full max-h-[500px] object-contain">
          @else
            <img src="{{ $r['original_image_url'] }}" 
                 alt="Gambar Asli"
                 class="rounded-lg shadow-lg w-full max-h-[500px] object-contain">
          @endif

          <div class="prediction-label">
            <p><strong>Prediksi:</strong> {{ $r['prediction'] ?? '–' }}</p>
            <p>
              <strong>Confidence:</strong>
              {{ isset($r['confidence']) ? $r['confidence'].'%' : '–' }}
            </p>

            @isset($r['warning'])
              <p class="text-yellow-400 mt-1">{{ $r['warning'] }}</p>
            @endisset

            @isset($r['error'])
              <p class="text-red-500 mt-1">{{ $r['error'] }}</p>
            @endisset
          </div>
        </div>

        {{-- Tombol Lihat Rekomendasi --}}
        @if(!isset($r['error']) && !isset($r['warning']) && !empty($r['prediction']))
          <a href="{{ route('diagnosis.recommendation', ['disease' => \Illuminate\Support\Str::slug($r['prediction'])]) }}"
            class="inline-block bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold px-8 py-3 rounded-full shadow-lg hover:scale-105 transition transform">
            Lihat Rekomendasi Penanganan
          </a>
        @endif

      @else
        <p class="text-white text-lg mb-6">
          Tidak ada data hasil prediksi. Silakan upload gambar terlebih dahulu.
        </p>
      @endif
    </div>
  </section>

</body>
@endsection

@section('extraJS')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const faders = document.querySelectorAll('.fade-in');
    const options = { threshold: 0.1, rootMargin: "0px 0px -100px 0px" };

    const observer = new IntersectionObserver(function (entries, observer) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    }, options);

    faders.forEach(el => observer.observe(el));
  });
</script>
@endsection