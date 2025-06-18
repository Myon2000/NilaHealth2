@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .image-preview-wrapper {
        position: relative;
        display: block;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .image-preview-wrapper:hover {
        transform: scale(1.02);
    }

    .image-preview-wrapper img {
        transition: all 0.5s ease;
    }

    .image-preview-wrapper:hover img {
        transform: scale(1.05);
    }

    .prediction-label {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        color: white;
        padding: 1rem;
        border-radius: 16px;
        font-weight: 500;
        font-size: 0.95rem;
        z-index: 10;
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .image-preview-wrapper:hover .prediction-label {
        transform: translateY(-5px);
    }

    .confidence-bar {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        margin-top: 8px;
        overflow: hidden;
    }

    .confidence-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 3px;
        transition: width 1s ease-out;
    }

    .cta-button {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: white;
        padding: 1rem 2rem;
        border-radius: 9999px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .cta-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .cta-button:hover::before {
        left: 100%;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }
    
    /* Alert Styles */
    .alert-warning {
        background: rgba(251, 191, 36, 0.15);
        border-left: 4px solid #f59e0b;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .alert-icon {
        flex-shrink: 0;
        margin-right: 1rem;
        padding: 0.5rem;
        background: rgba(251, 191, 36, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-title {
        font-weight: 600;
        color: #f59e0b;
        margin-bottom: 0.25rem;
    }
    
    .alert-message {
        color: rgba(255, 255, 255, 0.9);
    }

    .try-again-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 9999px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        margin-top: 1rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .try-again-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    @media (max-width: 640px) {
        .glass-card {
            padding: 1.25rem;
            margin: 1rem;
        }

        .prediction-label {
            bottom: 10px;
            left: 10px;
            right: 10px;
            padding: 0.75rem;
            font-size: 0.875rem;
        }

        h2 {
            font-size: 2rem !important;
        }

        .cta-button, .try-again-btn {
            width: 100%;
            padding: 1rem;
            text-align: center;
        }
        
        .alert-warning {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 pt-20 px-4 pb-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8 fade-in">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-4">
                AI-Powered Results
            </span>
            <h2 class="text-4xl font-extrabold text-white mb-4">Hasil Diagnosa</h2>
        </div>

        @php 
            $r = session('result'); 
            $isHighConfidence = isset($r['confidence']) && $r['confidence'] >= 80;
        @endphp

        @if($r)
            <div class="glass-card fade-in">
                <div class="image-preview-wrapper mb-6">
                    @if($isHighConfidence && !empty($r['predicted_image_url']))
                        {{-- Display prediction image when confidence is high --}}
                        <img src="{{ $r['predicted_image_url'] }}" 
                             alt="Gambar Prediksi"
                             class="w-full h-[400px] object-cover rounded-xl">
                    @elseif(!empty($r['original_image_url']))
                        {{-- Display original image when confidence is low --}}
                        <img src="{{ $r['original_image_url'] }}" 
                             alt="Gambar Asli"
                             class="w-full h-[400px] object-cover rounded-xl">
                    @endif
                    
                    {{-- Tampilkan label prediksi HANYA jika confidence tinggi --}}
                    @if($isHighConfidence && !empty($r['prediction']))
                        <div class="prediction-label">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-white/80">Prediksi:</span>
                                <span class="font-semibold">{{ $r['prediction'] }}</span>
                            </div>
                            
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80">Confidence:</span>
                                    <span class="font-semibold">{{ $r['confidence'] }}%</span>
                                </div>
                                <div class="confidence-bar">
                                    <div class="confidence-bar-fill" style="width: {{ $r['confidence'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                {{-- Warning untuk confidence rendah --}}
                @if(!$isHighConfidence && isset($r['confidence']))
                    <div class="alert-warning">
                        <div class="alert-icon">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="alert-content">
                            <h3 class="alert-title">Prediksi tidak dapat dipastikan</h3>
                            <p class="alert-message">Pastikan gambar yang di upload adalah gambar ikan nila.</p>
                        </div>
                    </div>

                    <div class="text-center mt-6">
                        <a href="{{ route('diagnosis.form') }}" class="try-again-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Coba lagi dengan gambar berbeda
                        </a>
                    </div>
                @elseif(isset($r['error']))
                    <div class="alert-warning">
                        <div class="alert-icon">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="alert-content">
                            <h3 class="alert-title">Terjadi Kesalahan</h3>
                            <p class="alert-message">{{ $r['error'] }}</p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-6">
                        <a href="{{ route('diagnosis.form') }}" class="try-again-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Coba lagi
                        </a>
                    </div>
                {{-- Tombol rekomendasi hanya ditampilkan jika confidence tinggi --}}
                @elseif($isHighConfidence && !empty($r['prediction']))
                    <div class="text-center">
                        <a href="{{ route('diagnosis.recommendation', ['disease' => \Illuminate\Support\Str::slug($r['prediction'])]) }}"
                           class="cta-button inline-flex items-center group">
                            <span>Lihat Rekomendasi Penanganan</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="glass-card text-center py-12 fade-in">
                <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-white/90 text-lg mb-6">
                    Tidak ada data hasil prediksi. Silakan upload gambar terlebih dahulu.
                </p>
                <a href="{{ route('diagnosis.form') }}" class="cta-button inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Upload Gambar
                </a>
            </div>
        @endif
    </div>
</div>
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
    
    // Handle image error
    const images = document.querySelectorAll('img');
    images.forEach(img => {
      img.addEventListener('error', function() {
        this.style.display = 'none';
        console.error('Failed to load image:', this.src);
      });
    });
  });
</script>
@endsection