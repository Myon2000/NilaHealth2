@extends('admin.layouts.app')
@section('title', 'Diagnosa')

@section('content')
<div class="overflow-x-auto">
  <table class="min-w-full bg-white dark:bg-gray-800">
    <thead>
      <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
        <th class="px-4 py-2">#</th>
        <th class="px-4 py-2 text-left">Penyakit</th>
        <th class="px-4 py-2 text-left">Rekomendasi Penanganan</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
      @forelse($diagnoses as $diagnosis)
        <tr>
          <td class="px-4 py-2">{{ $loop->iteration }}</td>
          <td class="px-4 py-2">{{ $diagnosis->hasil_diagnosis }}</td>
          <td class="px-4 py-2">
            {{ optional($diagnosis->penanganan)->deskripsi ?? '-' }}
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="px-4 py-2 text-center text-gray-500">
            Belum ada data diagnosa.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
