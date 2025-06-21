@extends('frontend.layouts.app')
@section('extraCSS')
<style>
    .bg-gradient-radial {
        background-image: radial-gradient(circle at center,
            var(--tw-gradient-from) 0%,
            var(--tw-gradient-via) 50%,
            var(--tw-gradient-to) 100%
        );
    }

    .animate-blob {
        animation: blob 10s infinite cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
            opacity: 0.3;
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
            opacity: 0.4;
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
            opacity: 0.3;
        }
        100% {
            transform: translate(0px, 0px) scale(1);
            opacity: 0.3;
        }
    }

    .bg-grid-pattern {
        background-image: linear-gradient(to right, currentColor 1px, transparent 1px),
                         linear-gradient(to bottom, currentColor 1px, transparent 1px);
        background-size: 30px 30px;
    }
    
    .modal-backdrop {
        transition: opacity 0.3s ease-in-out;
        opacity: 0;
    }

    .modal-backdrop.show {
        opacity: 1;
    }

    .modal-content {
        transition: all 0.3s ease-in-out;
        opacity: 0;
        transform: scale(0.95) translateY(-20px);
    }

    .modal-content.show {
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    #daysContainer {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }

    #daysContainer.show {
        max-height: 300px;
        opacity: 1;
    }

    .day-label {
        transition: all 0.2s ease-in-out;
        transform-origin: center;
    }

    .day-label:hover {
        transform: translateY(-2px);
    }

    .day-checkbox:checked + span {
        animation: checkPop 0.5s cubic-bezier(0.17, 0.67, 0.83, 0.67);
    }

    @keyframes checkPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .day-label .checkbox-bg {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
    }

    .day-checkbox:checked ~ .checkbox-bg {
        animation: bgPulse 0.6s ease-in-out;
    }

    @keyframes bgPulse {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.1); opacity: 0.3; }
        100% { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 640px) {
        .hero-title {
            font-size: 2.5rem !important;
            line-height: 1.2 !important;
        }
        
        .hero-description {
            font-size: 1rem !important;
            padding: 0 1rem;
        }
        
        .stats-container {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
            padding: 0 1rem;
        }
        
        .schedule-container {
            padding: 1rem !important;
        }
        
        .schedule-title {
            font-size: 1.875rem !important;
            line-height: 2.25rem !important;
        }
        
        .schedule-card {
            padding: 1rem !important;
        }
        
        .blog-container {
            padding: 1rem !important;
        }
        
        .blog-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
        
        .modal-content {
            margin: 1rem !important;
            padding: 1rem !important;
        }
        
        .modal-title {
            font-size: 1.5rem !important;
        }
        
        input, select, textarea {
            font-size: 16px !important;
        }
        
        .cta-button {
            width: 100% !important;
            justify-content: center !important;
        }
    }

    @media (min-width: 641px) and (max-width: 1024px) {
        .hero-title {
            font-size: 3rem !important;
        }
        
        .stats-container {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .blog-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    @media (max-width: 640px) {
        button, 
        .button,
        a {
            min-height: 44px !important;
            padding: 0.75rem 1rem !important;
        }
        
        .card-actions {
            display: flex !important;
            justify-content: space-around !important;
            padding-top: 1rem !important;
        }
        
        .card-actions button {
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem !important;
        }
    }

    @media (max-width: 640px) {
        .nav-menu {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            padding: 0.5rem !important;
            display: flex !important;
            justify-content: space-around !important;
            box-shadow: 0 -1px 10px rgba(0,0,0,0.1) !important;
            z-index: 50 !important;
        }
    }

    @media (max-width: 640px) {
        .loading-skeleton {
            opacity: 0.7 !important;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite !important;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 0.5; }
        }
    }

    #schedule {
        background-color: rgb(249, 250, 251);
    }

    .dark .waves .parallax > use:nth-child(1) {
        fill: rgba(17, 24, 39, 0.7); 
    }
    .dark .waves .parallax > use:nth-child(2) {
        fill: rgba(17, 24, 39, 0.8);
    }
    .dark .waves .parallax > use:nth-child(3) {
        fill: rgba(17, 24, 39, 0.9);
    }
    .dark .waves .parallax > use:nth-child(4) {
        fill: rgb(17, 24, 39); 
    }

    .dark .wave-transition {
        background: linear-gradient(
            to bottom,
            transparent,
            rgba(17, 24, 39, 0.9)
        );
    }

    .waves {
        position: relative;
        width: 100%;
        height: 15vh;
        margin-bottom: -7px;
        min-height: 100px;
        max-height: 150px;
    }

    .parallax > use {
        animation: moveWave 25s cubic-bezier(.55,.5,.45,.5) infinite;
    }

    .parallax > use:nth-child(1) {
        animation-delay: -2s;
        animation-duration: 7s;
        opacity: 0.7;
    }

    .parallax > use:nth-child(2) {
        animation-delay: -3s;
        animation-duration: 10s;
        opacity: 0.5;
    }

    .parallax > use:nth-child(3) {
        animation-delay: -4s;
        animation-duration: 13s;
        opacity: 0.3;
    }

    .parallax > use:nth-child(4) {
        animation-delay: -5s;
        animation-duration: 20s;
        opacity: 1;
    }

    .waves .parallax > use:nth-child(1) {
        fill: rgba(249, 250, 251, 0.7);
    }
    .waves .parallax > use:nth-child(2) {
        fill: rgba(249, 250, 251, 0.8);
    }
    .waves .parallax > use:nth-child(3) {
        fill: rgba(249, 250, 251, 0.9);
    }
    .waves .parallax > use:nth-child(4) {
        fill: #f9fafb;
    }

    @keyframes moveWave {
        0% {
            transform: translate3d(-90px,0,0);
        }
        100% { 
            transform: translate3d(85px,0,0);
        }
    }

    .wave-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
    }

    .wave-animation {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .wave-animation::before,
    .wave-animation::after {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 40%;
    }

    .wave-animation::before {
        animation: waveRotate 8s linear infinite;
    }

    .wave-animation::after {
        animation: waveRotate 15s linear infinite;
    }

    .wave-transition {
        position: relative;
        width: 100%;
        height: 150px;
        margin-top: -150px;
        pointer-events: none;
        background: linear-gradient(
            to bottom,
            transparent,
            rgb(249, 250, 251, 0.9)
        );
    }

    .wave-transition,
    .schedule-gradient {
        transition: background 0.3s ease;
    }

    .dark .schedule-gradient {
        background: linear-gradient(
            to bottom,
            rgb(17, 24, 39) 0%,
            rgb(31, 41, 55) 100%
        );
    }
    .schedule-gradient {
        background: linear-gradient(
            to bottom,
            rgb(249, 250, 251) 0%,
            rgb(243, 244, 246) 100%
        );
    }

    @keyframes waveRotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .waves {
            height: 40px;
            min-height: 40px;
        }
        
        .wave-animation::before,
        .wave-animation::after {
            top: -65%;
        }
    }
    .waves .parallax > use {
        transition: fill 0.3s ease;
    }

    @media (max-width: 480px) {
        .waves {
            height: 30px;
            min-height: 30px;
        }
    }

    .wave-glow {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 150px;
        background: linear-gradient(
            to bottom,
            transparent,
            rgba(255, 255, 255, 0.1)
        );
        filter: blur(10px);
    }

    @keyframes waveFlow {
        0% {
            background-position-x: 0;
        }
        100% {
            background-position-x: 200%;
        }
    }

    .wave-background {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 150px;
        background: linear-gradient(
            45deg,
            rgba(255,255,255,0.1) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255,255,255,0.1) 50%,
            rgba(255,255,255,0.1) 75%,
            transparent 75%,
            transparent
        );
        background-size: 30px 30px;
        animation: waveFlow 10s linear infinite;
        opacity: 0.3;
    }

    .waves svg {
        width: 100%;
        height: 100%;
        transform-origin: bottom;
        animation: waveRise 1s ease-out forwards;
    }

    @keyframes waveRise {
        from {
            transform: scaleY(0);
            opacity: 0;
        }
        to {
            transform: scaleY(1);
            opacity: 1;
        }
    }

    .wave-shimmer {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% {
            left: -100%;
        }
        100% {
            left: 200%;
        }
    }
</style>
@endsection

@section('content')
  <section class="snap-start min-h-screen bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 flex items-center relative transition-colors duration-300 overflow-hidden">
      <div class="absolute inset-0">
          <div class="absolute bottom-0 w-full overflow-hidden">
              <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                  viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                  <defs>
                      <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                  </defs>
                  <g class="parallax">
                      <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" class="dark:fill-gray-800/70" />
                      <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" class="dark:fill-gray-800/50" />
                      <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" class="dark:fill-gray-800/30" />
                      <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" class="dark:fill-gray-900" />
                  </g>
              </svg>
          </div>

          <div class="absolute top-20 left-16 w-40 h-40 bg-white/5 rounded-full blur-xl animate-pulse"></div>
          <div class="absolute bottom-16 right-20 w-52 h-52 bg-white/5 rounded-full blur-xl animate-pulse delay-1000"></div>
          
          <div class="absolute inset-0">
              <div class="particles-container"></div>
          </div>
      </div>
      
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm mb-8 hero-fade">
              <span class="animate-pulse w-2 h-2 rounded-full bg-green-400 mr-2"></span>
              <span class="text-white/90 text-sm font-medium">AI-Powered Fish Health Management</span>
          </div>

          <h1 class="text-white text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-6 hero-fade delay-1 hero-title">
              <span class="inline-block">Solusi Cerdas</span>
              <span class="inline-block bg-gradient-to-r from-blue-200 to-blue-100 text-transparent bg-clip-text">
                  untuk Nila Sehat
              </span>
          </h1>

          <p class="text-white/80 text-lg sm:text-xl max-w-3xl mx-auto mb-10 hero-fade delay-2">
              NilaHealth adalah platform cerdas yang membantu petani ikan dalam mendeteksi penyakit, 
              menganalisis kondisi ikan nila, dan mengelola kesehatan kolam secara efisien.
          </p>

          <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4 hero-fade delay-3">
              <a href="{{ route('diagnosis.form') }}" 
                class="group relative inline-flex items-center px-8 py-3 bg-white text-blue-700 rounded-full overflow-hidden transform hover:scale-105 transition-all duration-300">
                  <span class="absolute inset-0 bg-gradient-to-r from-blue-100 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                  <span class="relative flex items-center">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                      </svg>
                      Mulai Diagnosis
                  </span>
              </a>
          </div>

          <div class="grid md:grid-cols-4 gap-8 mt-16 max-w-4xl mx-auto hero-fade delay-4 stats-container">
              <div class="hidden md:block"></div>
              
              <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm">
                  <div class="text-3xl font-bold text-white mb-1">95%</div>
                  <div class="text-white/70">Akurasi Hingga</div>
              </div>
              
              <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm">
                  <div class="text-3xl font-bold text-white mb-1">24/7</div>
                  <div class="text-white/70">Monitoring</div>
              </div>
              
              <div class="hidden md:block"></div>
          </div>
  </section>

<div class="wave-transition"></div>

<section id="schedule" class="snap-start min-h-screen relative flex items-center justify-center schedule-gradient transition-colors duration-300 overflow-hidden -mt-1 py-8 sm:py-16">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-64 h-64 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/3 w-64 h-64 bg-pink-400 dark:bg-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>

        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

        <div class="absolute top-1/4 left-10 animate-float-slow">
            <svg class="w-12 h-12 text-blue-200 dark:text-blue-800" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="absolute bottom-1/4 right-10 animate-float-slow animation-delay-2000">
            <svg class="w-12 h-12 text-purple-200 dark:text-purple-800" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-4 relative z-10">
        <div class="text-center mb-8 sm:mb-12 fade-up">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4 transform hover:scale-105 transition-all duration-300">
                Pengingat Penanganan
            </span>
          <h2 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mt-2 mb-4 relative inline-block">
                Jadwal Penanganan
              <div class="absolute -bottom-2 left-0 right-0 h-1 bg-blue-600 transform scale-x-0 transition-transform duration-500 group-hover:scale-x-100"></div>
          </h2>
          <div class="flex items-center justify-center space-x-2 mb-4">
              <span class="w-8 h-1 bg-blue-600 rounded-full"></span>
              <span class="w-3 h-1 bg-blue-400 rounded-full"></span>
              <span class="w-3 h-1 bg-blue-400 rounded-full"></span>
          </div>
            <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-8 px-4 sm:px-0">
                Kelola jadwal penanganan ikan nila Anda dengan mudah dan terorganisir
            </p>
            
            <button onclick="openModal()" 
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg sm:rounded-full hover:bg-blue-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-blue-500/50">
                <span class="relative flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Jadwal Baru
                </span>
            </button>
        </div>

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            
            .animate-blob {
                animation: blob 7s infinite;
            }
            
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            
            .animation-delay-4000 {
                animation-delay: 4s;
            }
            
            .animate-float-slow {
                animation: float 6s ease-in-out infinite;
            }
            
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }

            .bg-grid-pattern {
                background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px);
                background-size: 30px 30px;
            }
        </style>
        
        @if($jadwals && $jadwals->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($jadwals as $jadwal)
            <div class="bg-white dark:bg-gray-800/95 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl p-4 sm:p-6 transform transition-all duration-300 border border-gray-100/10 dark:border-gray-700/50">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full px-3 py-1.5">
                        <span class="text-blue-800 dark:text-blue-200 text-sm font-medium">
                            {{ $jadwal->tanggal->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                            {{ $jadwal->waktu->format('H:i') }}
                        </span>
                    </div>
                </div>

                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-white mb-3">
                    {{ $jadwal->keterangan }}
                </h3>

                <div class="space-y-2.5">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="text-blue-600 dark:text-blue-400 text-sm font-medium">
                            {{ $jadwal->remind_before }} menit sebelumnya
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4 space-x-3">
                    <button onclick="editJadwal({{ $jadwal->id }})" 
                            class="p-2 text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button onclick="deleteJadwal({{ $jadwal->id }})"
                            class="p-2 text-red-600 hover:text-red-800 dark:hover:text-red-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 max-w-lg mx-auto border border-gray-100 dark:border-gray-700 relative overflow-hidden fade-up">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-bl-full transform translate-x-16 -translate-y-16"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-500/5 rounded-tr-full transform -translate-x-16 translate-y-16"></div>
                    
                    <div class="text-center relative z-10">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 mb-6 relative group">
                            <div class="absolute inset-0 rounded-full bg-blue-500/20 animate-ping group-hover:bg-blue-500/30"></div>
                            <svg class="w-12 h-12 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            Belum Ada Jadwal
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto leading-relaxed">
                            Mulai atur jadwal penanganan untuk memantau kesehatan ikan nila Anda. 
                            Dapatkan pengingat tepat waktu untuk perawatan yang optimal.
                        </p>

                        <button onclick="openModal()" 
                                class="inline-flex items-center px-6 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transform hover:scale-105 transition-all duration-300 group relative">
                            <span class="absolute inset-0 rounded-full bg-white/20 group-hover:animate-ping opacity-75"></span>
                            
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-2 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="relative">Buat Jadwal Pertama</span>
                            </span>
                        </button>

                        <div class="absolute bottom-4 right-4 flex space-x-1">
                            <div class="w-2 h-2 rounded-full bg-blue-500/30"></div>
                            <div class="w-2 h-2 rounded-full bg-purple-500/30"></div>
                            <div class="w-2 h-2 rounded-full bg-pink-500/30"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

    <div id="jadwalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 modal-backdrop">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl transform modal-content">
            <div class="flex items-center justify-between mb-6">
                <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Tambah Jadwal</span>
                </h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        <form id="jadwalForm" onsubmit="handleSubmit(event)" class="space-y-6">
        @csrf
        <input type="hidden" id="jadwal_id">

        <div class="grid grid-cols-2 gap-4">
            <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Tanggal
            </label>
            <input type="date" id="tanggal" name="tanggal" required
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Waktu
            </label>
            <input type="time" id="waktu" name="waktu" required
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Keterangan
            </label>
            <textarea id="keterangan" name="keterangan" rows="3" required
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Pengulangan
            </label>
            <select id="recurrence_type" name="recurrence_type" onchange="toggleDays()"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            <option value="once">Sekali</option>
            <option value="daily">Setiap Hari</option>
            <option value="custom">Custom</option>
            </select>
        </div>

        <div id="daysContainer" class="hidden space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Pilih Hari
            </label>
            <div class="grid grid-cols-3 gap-3">
                @foreach(['mon'=>'Senin','tue'=>'Selasa','wed'=>'Rabu','thu'=>'Kamis','fri'=>'Jumat','sat'=>'Sabtu','sun'=>'Minggu'] as $key=>$lbl)
                <label class="day-label relative flex items-center justify-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all">
                    <input type="checkbox" name="recurrence_days[]" value="{{ $key }}"
                        class="day-checkbox absolute opacity-0 peer"
                        onchange="toggleDayHighlight(this)">
                    <span class="text-sm text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">{{ $lbl }}</span>
                    <div class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Ingatkan Sebelum
            </label>
            <div class="flex items-center">
            <input type="number" id="remind_before" name="remind_before" min="0" required
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">menit</span>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
            <button type="button" onclick="closeModal()"
                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-colors">
            Batal
            </button>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan
            </button>
        </div>
        </form>
    </div>
    </div>

    <section id="article" class="snap-start min-h-screen relative flex items-center justify-center bg-gradient-to-b from-gray-100 via-gray-50 to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-900 py-16 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-64 h-64 bg-blue-400/30 dark:bg-blue-600/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-10 w-64 h-64 bg-purple-400/30 dark:bg-purple-600/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-pink-400/30 dark:bg-pink-600/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>

            <div class="absolute inset-0 bg-grid-pattern opacity-[0.03] dark:opacity-[0.05]"></div>

            <div class="absolute inset-0 bg-gradient-radial from-transparent via-white/50 to-white dark:via-gray-900/50 dark:to-gray-900 opacity-60"></div>

            <div class="absolute top-1/4 right-10 animate-float-slow">
                <svg class="w-12 h-12 text-blue-200 dark:text-blue-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div class="absolute bottom-1/4 left-10 animate-float-slow animation-delay-2000">
                <svg class="w-12 h-12 text-purple-200 dark:text-purple-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16 fade-up">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    Latest Updates
                </span>

                <h2 class="text-4xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 mb-4">
                    Artikel Terbaru
                </h2>

                <div class="flex items-center justify-center space-x-2 mb-4">
                    <span class="w-8 h-1 bg-blue-600 rounded-full"></span>
                    <span class="w-3 h-1 bg-blue-400 rounded-full"></span>
                    <span class="w-3 h-1 bg-blue-400 rounded-full"></span>
                </div>

                <p class="text-gray-600 dark:text-gray-300 text-lg max-w-2xl mx-auto">
                    Temukan informasi menarik seputar budidaya ikan yang kekinian dan up-to-date
                </p>
            </div>

            @if($latestArticles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($latestArticles as $article)
                <article class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden fade-up" style="animation-delay: {{ $loop->iteration * 100 }}ms">
                    <div class="p-6 relative">
                        <div class="flex items-center justify-between mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $article->tag === 'penyakit' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' : 
                                ($article->tag === 'perawatan' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : 
                                'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200') }}">
                                {{ ucfirst($article->tag) }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $article->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $article->judul }}
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($article->isi), 120) }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($article->author->name, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $article->author->name }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    {{ $article->comments->count() }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('articles.show', $article) }}" class="absolute inset-0 z-10">
                            <span class="sr-only">Read more about {{ $article->judul }}</span>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="text-center fade-up">
                <a href="{{ route('articles.index') }}" 
                class="group inline-flex items-center px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <span>Lihat Semua Artikel</span>
                    <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            @else
            <div class="text-center bg-white dark:bg-gray-800 rounded-2xl p-12 shadow-lg max-w-lg mx-auto border border-gray-100 dark:border-gray-700 fade-up">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 mb-6 relative group">
                    <div class="absolute inset-0 rounded-full bg-blue-500/20 animate-ping group-hover:bg-blue-500/30"></div>
                    <svg class="w-12 h-12 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Coming Soon!</h3>
                <p class="text-gray-600 dark:text-gray-400">Stay tuned! Artikel-artikel menarik akan segera hadir.</p>
            </div>
            @endif
        </div>
    </section>

@endsection

@section('extraJS')
<script>
  function showToast(message, type = 'success') {
      const toast = document.createElement('div');
      toast.className = `fixed bottom-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50 notification-enter`;
      toast.textContent = message;
      
      document.body.appendChild(toast);
      
      setTimeout(() => {
          toast.classList.replace('notification-enter', 'notification-leave');
          setTimeout(() => toast.remove(), 500);
      }, 2500);
  }
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

    function toggleDays() {
        const container = document.getElementById('daysContainer');
        const type = document.getElementById('recurrence_type').value;
        
        if (type === 'custom') {
            container.style.display = 'block';
            requestAnimationFrame(() => {
                container.classList.add('show');
                
                container.querySelectorAll('.day-label').forEach((label, index) => {
                    setTimeout(() => {
                        label.style.opacity = '0';
                        label.style.transform = 'translateX(-20px)';
                        requestAnimationFrame(() => {
                            label.style.opacity = '1';
                            label.style.transform = 'translateX(0)';
                        });
                    }, index * 50);
                });
            });
        } else {
            container.classList.remove('show');
            setTimeout(() => {
                container.style.display = 'none';
            }, 400);
        }
    }

    function openModal(isEdit = false) {
        const modal = document.getElementById('jadwalModal');
        const backdrop = modal;
        const content = modal.querySelector('.modal-content');
        
        if (!isEdit) {
            document.getElementById('jadwalForm').reset();
            document.getElementById('jadwal_id').value = '';
            document.getElementById('daysContainer').classList.remove('show');
            document.getElementById('modalTitle').textContent = 'Tambah Jadwal';
        }
        
        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            backdrop.classList.add('show');
            content.classList.add('show');
        });
    }

    function closeModal() {
        const modal = document.getElementById('jadwalModal');
        const backdrop = modal;
        const content = modal.querySelector('.modal-content');
        
        backdrop.classList.remove('show');
        content.classList.remove('show');
        
        setTimeout(() => {
            modal.style.display = 'none';
            document.getElementById('jadwalForm').reset();
            document.getElementById('jadwal_id').value = '';
            document.getElementById('daysContainer').classList.remove('show');
        }, 300);
    }


  async function handleSubmit(e) {
    e.preventDefault();
    const keterangan = document.getElementById('keterangan').value.trim();
    if (!keterangan) {
        showToast('Keterangan tidak boleh kosong', 'error');
        return;
    }
    const remind_before = parseInt(document.getElementById('remind_before').value);
    if (isNaN(remind_before) || remind_before < 0) {
        showToast('Waktu pengingat tidak valid', 'error');
        return;
    }
    const form = e.target;
    const id = document.getElementById('jadwal_id').value;
    const url = id? `/jadwal/${id}` : `/jadwal`;
    const method = id? 'PUT':'POST';

    let payload = {
      tanggal: document.getElementById('tanggal').value,
      waktu:    form.waktu.value,
      keterangan: form.keterangan.value,
      recurrence_type: form.recurrence_type.value,
      recurrence_days: [],
      remind_before: parseInt(form.remind_before.value)
    };
    if(payload.recurrence_type==='custom'){
      document.querySelectorAll('input[name="recurrence_days[]"]:checked')
              .forEach(cb=> payload.recurrence_days.push(cb.value));
    }

    const res = await fetch(url, {
      method, 
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(payload)
    });
    const j = await res.json();
    if(!res.ok) return showToast(j.message||'Gagal menyimpan');
    showToast(j.message);
    setTimeout(()=>location.reload(),800);
  }

    async function editJadwal(id) {
        openModal(true); 
        
        const res = await fetch(`/jadwal/${id}`);
        const data = await res.json();
        if(!res.ok) {
            closeModal();
            return showToast(data.message || 'Gagal ambil data');
        }

        document.getElementById('modalTitle').textContent = 'Edit Jadwal';
        
        const tanggal = new Date(data.tanggal);
        const formattedTanggal = tanggal.toISOString().split('T')[0];
        
        document.getElementById('jadwal_id').value = data.id;
        document.getElementById('tanggal').value = formattedTanggal;
        document.getElementById('waktu').value = data.waktu;
        document.getElementById('keterangan').value = data.keterangan;
        document.getElementById('recurrence_type').value = data.recurrence_type;
        document.getElementById('remind_before').value = data.remind_before;
        
        if(data.recurrence_type === 'custom') {
            document.getElementById('daysContainer').style.display = 'block';
            requestAnimationFrame(() => {
                document.getElementById('daysContainer').classList.add('show');
            });
            
            document.querySelectorAll('input[name="recurrence_days[]"]').forEach(cb => {
                cb.checked = data.recurrence_days?.includes(cb.value) || false;
                if(cb.checked) toggleDayHighlight(cb);
            });
        }
    }

  async function deleteJadwal(id) {
    if(!confirm('Yakin?')) return;
    const res = await fetch(`/jadwal/${id}`, {
      method:'DELETE',
      headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }
    });
    const j = await res.json();
    if(!res.ok) return showToast(j.message||'Gagal hapus');
    showToast(j.message);
    setTimeout(()=>location.reload(),500);
  }
    function toggleDayHighlight(checkbox) {
        const label = checkbox.closest('.day-label');
        if (checkbox.checked) {
            label.classList.add('border-blue-500', 'dark:border-blue-500');
            label.style.transform = 'scale(1.05)';
            setTimeout(() => {
                label.style.transform = 'scale(1)';
            }, 200);
        } else {
            label.classList.remove('border-blue-500', 'dark:border-blue-500');
        }
    }
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('jadwalModal');
        if (!modal.classList.contains('hidden')) {
            closeModal();
        }
    }
  });
  document.getElementById('jadwalModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) {
          closeModal();
      }
  });
</script>
@endsection