<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
</head>
<body class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

    <aside class="w-64 bg-blue-800 text-white min-h-screen">
        <div class="text-center py-6 text-xl font-bold border-b border-blue-700">
            Admin Panel
        </div>
        
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
            Dashboard
            </a>
        
            <a href="{{ route('admin.articles.index') }}" 
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.articles.*')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
                Artikel
            </a>
        
            <a href="{{ route('admin.users.index') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('admin.users.*')
                    ? 'bg-blue-700'
                    : 'hover:bg-blue-700' }}">
                Lihat Akun User
            </a>
        
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

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
        @yield('content')
    </main>
    <div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

    <script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded shadow-lg mb-2 transform translate-y-2 opacity-0 transition-all duration-300`;
        toast.innerHTML = message;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);

        setTimeout(() => {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    </script>

</body>
</html>