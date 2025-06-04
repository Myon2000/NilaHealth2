@extends('admin.layouts.app')

@section('title', 'List User')

@section('content')
@if(session('status'))
  <div class="mb-4 p-3 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded">
    {{ session('status') }}
  </div>
@endif

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
  <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Daftar User</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
            <a href="?direction={{ $direction=='asc'?'desc':'asc' }}" class="hover:underline">
              Last Login
              @if($direction=='asc')↑@else↓@endif
            </a>
          </th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Created At</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($users as $user)
        <tr>
          <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $user->name }}</td>
          <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $user->email }}</td>
          <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
            {{ $user->last_login
                 ? $user->last_login->format('d M Y H:i')
                 : '—' }}
          </td>
          <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
            {{ $user->created_at->format('d M Y') }}
          </td>
          <td class="px-4 py-3 text-sm">
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirmDelete(event, '{{ $user->email }}');">
              @csrf @method('delete')
              <button type="submit" class="p-2 text-red-600 hover:text-red-700 transition" aria-label="Hapus User">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                </svg>
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
            Belum ada user terdaftar.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script>
  function confirmDelete(e, email) {
    e.preventDefault();
    const input = prompt(`Ketik email user (“${email}”) untuk konfirmasi:`);
    if (input === email) {
      e.target.submit();
    } else if (input !== null) {
      alert('Email tidak cocok. Penghapusan dibatalkan.');
    }
    return false;
  }
</script>
@endsection