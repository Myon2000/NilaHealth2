@extends('frontend.layouts.app')

@section('extraCSS')
<style>
    /* Base animations */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Enhanced Card Styling */
    .recommendation-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        box-shadow: 
            0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .recommendation-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #eab308, #f59e0b);
        border-radius: 4px 0 0 4px;
    }

    .recommendation-card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 20px 25px -5px rgba(0, 0, 0, 0.1),
            0 10px 10px -5px rgba(0, 0, 0, 0.04),
            0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    /* Disease Name Animation */
    .disease-name {
        background: linear-gradient(120deg, #f59e0b, #eab308);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        display: inline-block;
    }

    .disease-name::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #f59e0b, transparent);
        animation: shimmerLine 2s infinite;
    }

    @keyframes shimmerLine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Steps List Styling */
    .treatment-steps {
        counter-reset: step;
    }

    .treatment-step {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 1.5rem;
        counter-increment: step;
    }

    .treatment-step::before {
        content: counter(step);
        position: absolute;
        left: 0;
        top: 0;
        width: 2rem;
        height: 2rem;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    /* Action Button Enhancement */
    .action-button {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .action-button:hover::before {
        left: 100%;
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .recommendation-card {
            margin: 1rem;
            padding: 1.25rem;
        }

        .disease-name {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .treatment-step {
            padding-left: 2.5rem;
        }

        .treatment-step::before {
            width: 1.75rem;
            height: 1.75rem;
            font-size: 0.75rem;
        }

        .action-button {
            width: 100%;
            text-align: center;
            padding: 1rem;
        }
    }

    /* Dark Mode Enhancements */
    .dark .recommendation-card {
        background: rgba(17, 24, 39, 0.95);
    }

    .dark .treatment-step::before {
        background: linear-gradient(135deg, #4f46e5, #3730a3);
    }

    .dark .action-button {
        background: linear-gradient(135deg, #4f46e5, #3730a3);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-800 dark:from-gray-900 dark:to-gray-800 pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto space-y-8 fade-in">
            <!-- Header -->
            <div class="text-center space-y-4">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                    Hasil Diagnosa
                </span>
                <h1 class="text-4xl font-bold text-white">Rekomendasi Penanganan</h1>
                <p class="text-lg text-white/80">Berdasarkan hasil diagnosa, ikan terdeteksi mengalami:</p>
                <h2 class="text-3xl font-bold disease-name mb-8">
                    {{ $disease ?? 'Tidak diketahui' }}
                </h2>
            </div>

            <!-- Recommendation Card -->
            <div class="recommendation-card p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="rounded-full bg-blue-100 dark:bg-blue-900/50 p-3">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-xl font-semibold text-gray-900 dark:text-white">
                        Langkah Penanganan
                    </h3>
                </div>

                <div class="treatment-steps space-y-6">
                    @if($recommendation)
                        @foreach(explode("\n", $recommendation) as $step)
                            <div class="treatment-step">
                                <p class="text-gray-700 dark:text-gray-300">{{ $step }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-4 text-gray-500 dark:text-gray-400">Belum ada rekomendasi tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Button -->
            <div class="text-center pt-8">
                <a href="{{ route('diagnosis.form') }}" class="action-button inline-flex items-center group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Diagnosa Ulang
                </a>
            </div>
        </div>
    </div>
</div>
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