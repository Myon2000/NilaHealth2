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
    /* Container preview gambar sebelum upload */
    #preview-container {
      margin-top: 1rem;
    }
    #preview-image {
      max-height: 24rem; /* 96 */
      object-contain: contain;
      width: 100%;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
  </style>
@endsection

@section('content')
<body class="snap-y snap-mandatory h-screen overflow-y-scroll pt-20">

  <!-- Section: Form Diagnosa -->
  <section class="snap-start min-h-screen bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center transition-colors duration-300">
    <div class="max-w-2xl w-full px-4 text-center fade-in">
      <h2 class="text-4xl font-extrabold text-white mb-4">Diagnosa Penyakit Ikan Nila</h2>
      <p class="text-lg text-white mb-8">
        Silakan unggah gambar ikan nila Anda, lalu klik tombol Diagnosa Sekarang.
      </p>

      {{-- Form upload gambar ke route diagnosis.predict --}}
      <form method="POST" action="{{ route('diagnosis.predict') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="text-left">
          <label for="image" class="block mb-2 font-medium text-white">Pilih Gambar</label>
          <input
            type="file"
            id="image"
            name="image"
            accept="image/*"
            onchange="previewImage(event)"
            required
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white text-gray-800"
          >
          @error('image')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

     {{--  --}}
        <div id="preview-container" class="hidden text-left">
          <p class="mb-2 font-medium text-white">Pratinjau Gambar:</p>
          <img id="preview-image" src="#" alt="Pratinjau Gambar" />
        </div>

        <div class="pt-4">
          <button
            type="submit"
            class="inline-block bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold px-8 py-3 rounded-full shadow-lg hover:scale-105 transition transform"
          >
            Diagnosa Sekarang
          </button>
        </div>
      </form>

    </div>
  </section>

</body>
@endsection

@section('extraJS')
<script>
  // Animasi fade-in saat scroll
  document.addEventListener("DOMContentLoaded", function () {
    const faders = document.querySelectorAll('.fade-in');
    const options = { threshold: 0.1, rootMargin: "0px 0px -100px 0px" };
    const observer = new IntersectionObserver(function (entries, observer) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, options);
    faders.forEach(el => observer.observe(el));
  });

  // Fungsi preview gambar sebelum diupload
  function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    if (!file) {
      previewContainer.classList.add('hidden');
      return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImage.src = e.target.result;
      previewContainer.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
</script>
@endsection