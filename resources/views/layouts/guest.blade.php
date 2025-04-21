<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NilaHealth</title>
  <link rel="icon" href="{{ asset('assets/logos/logo-if-icon.png') }}" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css','resources/js/app.js'])
  @yield('extraCSS')
</head>
<body class="font-[Poppins] bg-white text-gray-800 m-0 p-0">
  <main class="flex-grow w-full overflow-x-hidden">
    @yield('content')
  </main>
  @yield('extraJS')
</body>
</html>
