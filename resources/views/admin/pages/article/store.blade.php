@extends('admin.layouts.app')

@section('content')
<div class="container px-6 mx-auto grid">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Tambah Artikel Baru
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.articles.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Judul Artikel
                </label>
                <input type="text" id="judul" name="judul" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    value="{{ old('judul') }}" 
                    required>
                @error('judul')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="isi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Isi Artikel
                </label>
                <textarea id="editor" name="isi" rows="10" 
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Tag Artikel
                </label>
                <select id="tag" name="tag" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Pilih Tag</option>
                    <option value="penyakit" {{ old('tag') == 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                    <option value="perawatan" {{ old('tag') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="budidaya" {{ old('tag') == 'budidaya' ? 'selected' : '' }}>Budidaya</option>
                </select>
                @error('tag')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.articles.index') }}" 
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Batal
                </a>
                <button type="submit" 
                    id="submitBtn"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <span class="inline-flex items-center">
                        <svg id="loadingIcon" class="hidden w-4 h-4 mr-2 animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="submitText">Simpan Artikel</span>
                    </span>
                </button>
                @if(session('success'))
                <div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg transition-opacity duration-300">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div id="toast" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg transition-opacity duration-300">
                    {{ session('error') }}
                </div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@section('extraJS')
<script>
    let editor;
    let formChanged = false;

    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
        })
        .then(newEditor => {
            editor = newEditor;
            
            editor.model.document.on('change:data', () => {
                formChanged = true;
            });
        })
        .catch(error => {
            console.error(error);
        });

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded shadow-lg z-50 transform transition-all duration-300 opacity-0 translate-y-2`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-2');
        }, 10);
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const judul = document.getElementById('judul');
        const editor = document.querySelector('.ck-editor__editable');
        const tag = document.getElementById('tag');
        let isValid = true;

        document.querySelectorAll('.error-message').forEach(el => el.remove());
        
        if (!judul.value.trim()) {
            showFieldError(judul, 'Mohon isi judul artikel');
            isValid = false;
        }

        if (!editor.innerHTML.trim()) {
            showFieldError(editor, 'Mohon isi konten artikel');
            isValid = false;
        }

        if (!tag.value) {
            showFieldError(tag, 'Mohon pilih tag artikel');
            isValid = false;
        }

        if (!isValid) return;

        const submitBtn = document.getElementById('submitBtn');
        const loadingIcon = document.getElementById('loadingIcon');
        const submitText = document.getElementById('submitText');
        
        submitBtn.disabled = true;
        loadingIcon.classList.remove('hidden');
        submitText.textContent = 'Menyimpan...';

        this.submit();
    });

    function showFieldError(element, message) {
        const error = document.createElement('p');
        error.className = 'error-message text-sm text-red-600 mt-1';
        error.textContent = message;
        element.parentNode.appendChild(error);
        element.classList.add('border-red-500');
    }

    document.querySelector('form').addEventListener('input', () => {
        formChanged = true;
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });


</script>
@endsection