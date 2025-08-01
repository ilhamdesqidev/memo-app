@extends('layouts.divisi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Buat Memo Baru</h1>
            <p class="text-gray-600 mt-1">Buat memo untuk komunikasi antar divisi</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Section -->
        <form action="{{ route($routePrefix . '.memo.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Memo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Memo *</label>
                        <input type="text" name="nomor" value="{{ old('nomor') }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal *</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Kepada -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Kepada *</label>
                        <input type="text" id="kepada_search" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Cari nama penerima..." autocomplete="off">
                        <input type="hidden" name="kepada" id="kepada">
                        <input type="hidden" name="kepada_id" id="kepada_id">
                        <div id="kepadaDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"></div>
                    </div>

                    <!-- Dari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari</label>
                        <input type="text" value="{{ auth()->user()->divisi->nama }}" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <input type="hidden" name="dari" value="{{ auth()->user()->divisi->nama }}">
                    </div>

                    <!-- Perihal -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Perihal *</label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Divisi Tujuan -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Divisi Tujuan *</label>
                        <input type="text" name="divisi_tujuan" id="divisi_tujuan" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Isi Memo dengan Rich Text Editor -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Isi Memo *</label>
                        <div class="mt-1">
                            <!-- Quill Editor Container -->
                            <div id="editor-container" style="height: 300px; background: white;"></div>
                            <!-- Hidden textarea for form submission -->
                            <textarea name="isi" id="isi_memo" style="display: none;" required>{{ old('isi') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Memo
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Quill.js CDN - Modern Rich Text Editor -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge',] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Tulis isi memo di sini...',
        bounds: '#editor-container'
    });

    // Set initial content if exists
    var initialContent = document.getElementById('isi_memo').value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    // Update hidden textarea when content changes
    quill.on('text-change', function() {
        document.getElementById('isi_memo').value = quill.root.innerHTML;
    });

    // User search functionality
    const searchInput = document.getElementById('kepada_search');
    const kepadaInput = document.getElementById('kepada');
    const kepadaIdInput = document.getElementById('kepada_id');
    const divisiInput = document.getElementById('divisi_tujuan');
    const dropdown = document.getElementById('kepadaDropdown');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            dropdown.classList.add('hidden');
            return;
        }

        fetch(`/api/search-users?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                dropdown.innerHTML = '';
                
                if (users.length === 0) {
                    dropdown.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ditemukan</div>';
                } else {
                    users.forEach(user => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        div.innerHTML = `
                            <div class="font-medium">${user.name}</div>
                            <div class="text-xs text-gray-500">${user.divisi_nama}</div>
                        `;
                        div.addEventListener('click', () => {
                            searchInput.value = user.name;
                            kepadaInput.value = user.name;
                            kepadaIdInput.value = user.id;
                            divisiInput.value = user.divisi_nama;
                            dropdown.classList.add('hidden');
                        });
                        dropdown.appendChild(div);
                    });
                }
                dropdown.classList.remove('hidden');
            });
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Form submission handler
    document.querySelector('form').addEventListener('submit', function(e) {
        // Ensure Quill content is saved to textarea before submission
        document.getElementById('isi_memo').value = quill.root.innerHTML;
    });
});
</script>

<style>
/* Custom styles for Quill Editor */
.ql-toolbar {
    border: 1px solid #d1d5db !important;
    border-bottom: none !important;
    border-top-left-radius: 0.375rem !important;
    border-top-right-radius: 0.375rem !important;
    background: #f9fafb !important;
}

.ql-container {
    border: 1px solid #d1d5db !important;
    border-bottom-left-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
    font-family: inherit !important;
}

.ql-editor {
    font-size: 14px !important;
    line-height: 1.5 !important;
    min-height: 250px !important;
}

.ql-editor.ql-blank::before {
    color: #9ca3af !important;
    font-style: normal !important;
}

/* Focus styles */
.ql-container.ql-snow.ql-focused {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 1px #3b82f6 !important;
}

.ql-toolbar.ql-snow.ql-focused {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 1px #3b82f6 !important;
}

/* Toolbar button styles */
.ql-toolbar.ql-snow .ql-formats {
    margin-right: 15px !important;
}

.ql-toolbar.ql-snow button:hover {
    color: #3b82f6 !important;
}

.ql-toolbar.ql-snow button.ql-active {
    color: #1d4ed8 !important;
}
</style>
@endsection