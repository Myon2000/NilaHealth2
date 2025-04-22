<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 text-white min-h-screen">
        <div class="text-center py-6 text-xl font-bold border-b border-blue-700">
            Admin Panel
        </div>
        
        <nav class="p-4 space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
            Dashboard
            </a>
        
            {{-- Artikel --}}
            <a href="#" 
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.artikel*')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
            Artikel
            </a>
        
            {{-- Liat Akun User --}}
            <a href="{{ route('admin.users') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.users')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
            Liat Akun User
            </a>
        
            {{-- Penanganan Penyakit (Diagnoses) --}}
            <a href="{{ route('admin.diagnoses') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.diagnoses')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
            Penanganan Penyakit
            </a>
        </nav>
        
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-700">
            @csrf
            <button type="submit"
                    class="w-full text-left px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition">
            Logout
            </button>
        </form>
    </aside>      

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
        @yield('content')
    </main>

</body>
</html>