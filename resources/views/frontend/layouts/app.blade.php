<!doctype html>
<html lang="en" class="scroll-smooth dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name','NilaHealth') }}</title>
  <link rel="icon" href="{{ asset('assets/logos/logo-if-icon.png') }}" type="image/x-icon">

  <!-- Fonts & Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">

  @yield('extraCSS')

  <style>
    /* Toast container */
    #toast {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      max-width: 20rem;
      padding: .75rem 1.25rem;
      background: rgba(0,0,0,0.8);
      color: #fff;
      border-radius: .5rem;
      opacity: 0;
      transform: translateY(1rem);
      transition: opacity .3s ease, transform .3s ease;
      pointer-events: none;
      z-index: 9999;
    }
    #toast.show {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
  </style>
</head>

<body class="font-[Poppins] bg-white dark:bg-gray-950 text-gray-800 dark:text-white m-0 p-0">
  <div class="min-h-screen flex flex-col">
    @include('frontend.components.navbar')

    <main class="flex-grow">
      @yield('content')
    </main>

    @include('frontend.components.footer')
  </div>

  <!-- Toast element -->
  <div id="toast"></div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script>
    // Inisialisasi DataTable (cek agar tidak diinis ulang)
    document.addEventListener('DOMContentLoaded', function() {
        const tbl = $('#dataTable');
        if (tbl.length && !$.fn.DataTable.isDataTable('#dataTable')) {
            tbl.DataTable({ columnDefs:[{ targets:'_all', className:'dt-center' }] });
        }
    });

    // Fungsi toast sederhana
    window.showToast = function(message, duration = 3000) {
      const t = document.getElementById('toast');
      t.textContent = message;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), duration);
    };
  </script>

  <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

  @vite(['resources/css/app.css','resources/js/app.js'])
  @yield('extraJS')
  @stack('scripts')

</body>
</html>
