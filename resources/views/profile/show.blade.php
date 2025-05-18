@extends('frontend.layouts.app')

@section('extraCSS')
<style>
  /* Base animations */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideIn {
    from { transform: translateX(-100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
  }

  @keyframes shine {
    from { transform: translateX(-100%) rotate(45deg); }
    to { transform: translateX(200%) rotate(45deg); }
  }

  .fade-in {
    opacity: 0;
    animation: fadeIn 1s ease-in-out forwards;
  }

  .slide-in {
    animation: slideIn 0.8s ease-out forwards;
  }

  .fade-delay-1 { animation-delay: 0.3s; }
  .fade-delay-2 { animation-delay: 0.6s; }
  .fade-delay-3 { animation-delay: 0.9s; }

  /* Enhanced Profile Card */
  .profile-card {
    background: #ffffff;
    border-radius: 1.5rem;
    border: 1px solid rgba(226, 232, 240, 1);
    box-shadow: 
      0 4px 6px -1px rgba(0, 0, 0, 0.1),
      0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
  }

  .dark .profile-card {
    background: #1e293b;
    border-color: rgba(51, 65, 85, 1);
  }

  /* Information Rows */
  .info-row {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
  }

  .info-row:hover {
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .dark .info-row {
    background: #0f172a;
    border-color: #334155;
  }

  .dark .info-row:hover {
    background: #1e293b;
  }

  /* Text Styling */
  .info-label {
    color: #475569;
    font-size: 0.925rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
  }

  .info-value {
    color: #0f172a;
    font-size: 1.025rem;
    font-weight: 600;
  }

  .dark .info-label {
    color: #cbd5e1;
  }

  .dark .info-value {
    color: #f8fafc;
  }

  /* Enhanced Button */
  .btn-shine {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 9999px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-shine:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
  }

  .btn-shine::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
      45deg,
      transparent 45%,
      rgba(255, 255, 255, 0.5) 50%,
      transparent 55%
    );
    animation: shine 3s infinite;
  }

  /* Responsive Design */
  @media (max-width: 640px) {
    .profile-card {
      margin: 1rem;
      padding: 1.25rem;
    }

    .info-row {
      padding: 1rem;
      margin-bottom: 0.75rem;
    }

    .info-label {
      font-size: 0.875rem;
    }

    .info-value {
      font-size: 1rem;
    }

    .btn-shine {
      width: 100%;
      padding: 0.875rem 1.5rem;
      font-size: 0.9375rem;
    }
  }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-800 via-blue-600 to-blue-400 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 pt-16">
  <!-- Header Section -->
  <div class="text-center py-12 px-4">
    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4 slide-in">
      {{ $user->name }}
    </h1>
    <p class="text-lg text-white/90 mb-8 fade-in fade-delay-1">
      Manage your account information
    </p>
  </div>

  <!-- Profile Card -->
  <div class="max-w-2xl mx-auto px-4 pb-12">
    <div class="profile-card p-6 sm:p-8 fade-in fade-delay-2">
      <div class="flex items-center mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div class="bg-blue-500 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
          Account Information
        </h2>
      </div>

      <!-- Information Rows -->
      <div class="space-y-4">
        <div class="info-row">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <span class="info-label">Name</span>
            <span class="info-value">{{ $user->name }}</span>
          </div>
        </div>

        <div class="info-row">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email }}</span>
          </div>
        </div>

        <div class="info-row">
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <span class="info-label">Member Since</span>
            <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <div class="mt-8 text-center">
        <a href="{{ route('profile.edit') }}" 
           class="btn-shine inline-flex items-center justify-center group">
          <span>Edit Profile</span>
          <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" 
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection