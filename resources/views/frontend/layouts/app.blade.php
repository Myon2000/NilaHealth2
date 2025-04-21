<!doctype html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NilaHealth</title>
    <link rel="icon" href="{{ asset('assets/logos/logo-if-icon.png') }}" type="image/x-icon">

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <!-- Font Awesome Pro -->
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <!-- Tailwind & JS (via Vite) -->
    

    @yield('extraCSS')
    @yield('topJS')

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                columnDefs: [{ targets: "_all", className: 'dt-center' }]
            });
        });
    </script>
</head>

<body class="font-[Poppins] bg-white dark:bg-gray-950 text-gray-800 dark:text-white m-0 p-0">
    <div class="min-h-screen flex flex-col mx-auto w-full overflow-x-hidden">
        @include('frontend.components.navbar')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('frontend.components.footer')
    </div>

    @yield('extraJS')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Theme script moved to bottom, after DOM is fully loaded -->
    
</body>
</html>