@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    @media (max-width: 640px) {
        .diagnose-container {
            max-height: calc(100vh - 6rem);
            padding: 1.25rem;
        }

        #preview-container {
            max-height: 200px; /* Smaller height for mobile */
        }

        h2 {
            font-size: 1.875rem !important;
            line-height: 2.25rem !important;
        }

        .file-input-trigger {
            padding: 1.5rem;
        }

        #preview-image {
            max-height: 200px;
        }

        .diagnose-button {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1.5rem;
        }
    }

    /* Custom scrollbar untuk mobile */
    @media (max-width: 640px) {
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }
    }
    
    /* Animation and Transitions */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .fade-in.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Updated Preview Container Styles */
    .diagnose-container {
        max-height: calc(100vh - 8rem); /* Account for header and padding */
        overflow-y: auto;
        scrollbar-width: thin;
        -ms-overflow-style: none;
    }

    .diagnose-container::-webkit-scrollbar {
        width: 4px;
    }

    .diagnose-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .diagnose-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    /* File Input Styling */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
        cursor: pointer;
    }

    .file-input-trigger {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.1);
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .file-input-trigger:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Preview Container */
    #preview-container {
        margin-top: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        max-height: 300px; /* Adjust this value as needed */
        overflow: hidden;
    }

    #preview-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        max-height: 300px; /* Match container max-height */
    }

    #preview-image:hover {
        transform: scale(1.02);
    }

    .preview-enter {
        opacity: 0;
        transform: scale(0.95);
    }
    
    .preview-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 0.3s, transform 0.3s;
    }

    /* Button Enhancement */
    .diagnose-button {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
        transition: all 0.3s ease;
    }

    .diagnose-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Dark Mode Enhancements */
    .dark .diagnose-container {
        background: rgba(17, 24, 39, 0.7);
    }

    .dark .file-input-trigger {
        background: rgba(17, 24, 39, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .preview-loading::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="h-screen pt-16">
    <section class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center transition-colors duration-300 p-4 sm:p-6">
        <div class="w-full max-w-2xl diagnose-container fade-in">

            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs sm:text-sm font-medium mb-3 sm:mb-4">
                    AI-Powered Diagnosis
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3 sm:mb-4">Diagnosa Penyakit Ikan Nila</h2>
                <p class="text-base sm:text-lg text-white/90">
                    Silakan unggah gambar ikan nila Anda, lalu klik tombol Diagnosa Sekarang.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('diagnosis.predict') }}" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
                @csrf
                <div class="file-input-wrapper">
                    <div class="file-input-trigger">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-white/90">Klik atau seret gambar ke sini</p>
                        </div>
                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                            onchange="previewImage(event)"
                            required
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                    </div>
                    @error('image')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div id="preview-container" class="hidden">
                    <p class="mb-3 font-medium text-white">Pratinjau Gambar:</p>
                    <img id="preview-image" src="#" alt="Pratinjau Gambar" />
                </div>

                <div class="pt-6 text-center">
                    <button type="submit" class="diagnose-button inline-flex items-center px-8 py-3 rounded-full text-blue-700 font-semibold shadow-lg group">
                        <span>Diagnosa Sekarang</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
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

    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const fileInput = event.target;
        const fileInputTrigger = fileInput.parentElement;

        if (!file) {
            previewContainer.classList.add('hidden');
            fileInputTrigger.classList.remove('border-blue-500');
            return;
        }

        // Add loading state
        previewContainer.classList.add('preview-loading');
        previewContainer.classList.remove('hidden');
        
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create new image to check dimensions
            const img = new Image();
            img.onload = function() {
                previewImage.src = e.target.result;
                
                // Add entrance animation classes
                previewContainer.classList.add('preview-enter');
                requestAnimationFrame(() => {
                    previewContainer.classList.add('preview-enter-active');
                    previewContainer.classList.remove('preview-enter', 'preview-loading');
                });

                fileInputTrigger.classList.add('border-blue-500');
                
                // Smooth scroll only if preview is out of view
                const containerRect = previewContainer.getBoundingClientRect();
                const isOutOfView = containerRect.bottom > window.innerHeight;
                
                if (isOutOfView) {
                    previewContainer.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest'
                    });
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Add error handling
        reader.onerror = function() {
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('preview-loading');
            alert('Error loading image. Please try again.');
        };
    }
</script>
@endsection