@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 pt-24 pb-8">
  <div class="text-center mb-12">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">
      Jadwal Penanganan Ikan
    </h1>
    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
      Kelola jadwal penanganan ikan nila Anda dengan mudah dan terorganisir
    </p>
    <button onclick="openModal()" 
            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
      </svg>
      Tambah Jadwal Baru
    </button>
  </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pengulangan</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pengingat</span>
                </div>
            </th>
            <th scope="col" class="px-6 py-4">
                <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</span>
                </div>
            </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($jadwals as $jadwal)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 dark:text-blue-300 text-sm font-medium">
                        {{ $jadwal->tanggal->format('d') }}
                    </span>
                    </div>
                    <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $jadwal->tanggal->format('M Y') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $jadwal->tanggal->format('l') }}
                    </div>
                    </div>
                </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ $jadwal->waktu->format('H:i') }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    WIB
                </div>
                </td>
                <td class="px-6 py-4">
                <div class="text-sm text-gray-900 dark:text-white line-clamp-2">
                    {{ $jadwal->keterangan }}
                </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $jadwal->recurrence_type === 'once' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : 
                    ($jadwal->recurrence_type === 'daily' ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300' : 
                        'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-300') }}">
                    @if($jadwal->recurrence_type === 'once')
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Sekali</span>
                    @elseif($jadwal->recurrence_type === 'daily')
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Setiap Hari</span>
                    @else
                    <span>{{ implode(', ', $jadwal->recurrence_days) }}</span>
                    @endif
                </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $jadwal->remind_before }} menit
                </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end space-x-3">
                    <button onclick="editJadwal({{ $jadwal->id }})" 
                            class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 transition-colors duration-200">
                    <span class="sr-only">Edit</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    </button>
                    <button onclick="deleteJadwal({{ $jadwal->id }})"
                            class="text-red-600 hover:text-red-900 dark:hover:text-red-400 transition-colors duration-200">
                    <span class="sr-only">Delete</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    </button>
                </div>
                </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-8 text-center">
                <div class="flex flex-col items-center">
                  <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <p class="text-gray-500 dark:text-gray-400 text-lg mb-2">Tidak ada jadwal</p>
                  <p class="text-gray-400 dark:text-gray-500 text-sm mb-4">Mulai buat jadwal penanganan untuk ikan nila Anda</p>
                  <button onclick="openModal()" 
                          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Jadwal
                  </button>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="jadwalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
    <div class="flex items-center justify-between mb-6">
      <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span></span>
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
@endsection

@section('extraJS')
<script>
  function toggleDays() {
    const val = document.getElementById('recurrence_type').value;
    document.getElementById('daysContainer')
            .classList.toggle('hidden', val!=='custom');
  }

    function openModal(isEdit = false) {
    if (!isEdit) {
        document.getElementById('jadwalForm').reset();
        document.getElementById('jadwal_id').value = '';
        document.getElementById('daysContainer').classList.add('hidden');
        document.getElementById('modalTitle').textContent = 'Tambah Jadwal';
    }
    document.getElementById('jadwalModal').classList.replace('hidden','flex');
    }

  function closeModal() {
    document.getElementById('jadwalModal')
            .classList.replace('flex','hidden');
  }

  async function handleSubmit(e) {
    e.preventDefault();
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
    document.getElementById('jadwalModal').classList.replace('hidden','flex');
    
    const res = await fetch(`/jadwal/${id}`);
    const data = await res.json();
    if(!res.ok) {
        closeModal();
        return showToast(data.message||'Gagal ambil data');
    }

    document.getElementById('modalTitle').textContent = 'Edit Jadwal';
    
    document.getElementById('jadwal_id').value = data.id;
    document.getElementById('tanggal').value = data.tanggal;
    document.getElementById('waktu').value = data.waktu;
    document.getElementById('keterangan').value = data.keterangan;
    document.getElementById('recurrence_type').value = data.recurrence_type;
    document.getElementById('remind_before').value = data.remind_before;
    
    toggleDays();
    document.querySelectorAll('input[name="recurrence_days[]"]').forEach(cb => {
        cb.checked = data.recurrence_days?.includes(cb.value) || false;
    });
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
        label.classList.add('border-blue-500', 'dark:border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    } else {
        label.classList.remove('border-blue-500', 'dark:border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    }
    }
</script>
@endsection
