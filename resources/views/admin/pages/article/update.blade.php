@extends('admin.layouts.app')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Edit Artikel
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Judul Artikel
                </label>
                <input type="text" id="judul" name="judul" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    value="{{ old('judul', $article->judul) }}" 
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
                    required>{{ old('isi', $article->isi) }}</textarea>
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
                    <option value="penyakit" {{ old('tag', $article->tag) == 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                    <option value="perawatan" {{ old('tag', $article->tag) == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="budidaya" {{ old('tag', $article->tag) == 'budidaya' ? 'selected' : '' }}>Budidaya</option>
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
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extraJS')
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
    let formChanged = false;

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const judul = document.getElementById('judul');
        const editor = document.querySelector('.ck-editor__editable');
        const tag = document.getElementById('tag');
        let isValid = true;

        // Reset previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        
        // Validate title
        if (!judul.value.trim()) {
            showFieldError(judul, 'Mohon isi judul artikel');
            isValid = false;
        }

        // Validate content
        if (!editor.innerHTML.trim()) {
            showFieldError(editor, 'Mohon isi konten artikel');
            isValid = false;
        }

        // Validate tag
        if (!tag.value) {
            showFieldError(tag, 'Mohon pilih tag artikel');
            isValid = false;
        }

        if (!isValid) return;

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const loadingIcon = document.getElementById('loadingIcon');
        const submitText = document.getElementById('submitText');
        
        submitBtn.disabled = true;
        loadingIcon.classList.remove('hidden');
        submitText.textContent = 'Menyimpan...';

        // Submit form
        this.submit();
    });

    function showFieldError(element, message) {
        const error = document.createElement('p');
        error.className = 'error-message text-sm text-red-600 mt-1';
        error.textContent = message;
        element.parentNode.appendChild(error);
        element.classList.add('border-red-500');
    }

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endsection