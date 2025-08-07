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

                    <!-- Kepada (Manual Input) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kepada *</label>
                        <input type="text" name="kepada" value="{{ old('kepada') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Dari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari</label>
                        <input type="text" value="{{ auth()->user()->divisi->nama }}" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <input type="hidden" name="dari" value="{{ auth()->user()->divisi->nama }}">
                    </div>

                    <!-- Divisi Tujuan (Searchable Dropdown) -->
                    <div class="relative md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Divisi Tujuan *</label>
                        <div class="relative">
                            <input type="text" id="divisi_search" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Cari nama atau divisi asisten manager..." autocomplete="off">
                            <input type="hidden" name="divisi_tujuan" id="divisi_tujuan">
                            <input type="hidden" name="kepada_id" id="kepada_id">
                            <div id="divisiDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"></div>
                            <button type="button" id="clearSelection" class="absolute right-2.5 bottom-2.5 text-gray-400 hover:text-gray-600 hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-gray-500" id="selectedDivisiText"></p>
                    </div>

                    <!-- Perihal -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Perihal *</label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
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
                [{ 'size': ['small', false, 'large', 'huge'] }],
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

    // Divisi Tujuan search functionality (only for asisten_manager)
    const divisiSearchInput = document.getElementById('divisi_search');
    const divisiTujuanInput = document.getElementById('divisi_tujuan');
    const kepadaIdInput = document.getElementById('kepada_id');
    const divisiDropdown = document.getElementById('divisiDropdown');
    const clearSelectionBtn = document.getElementById('clearSelection');
    const selectedDivisiText = document.getElementById('selectedDivisiText');

    // Search functionality with debounce
    let searchTimeout;
    divisiSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                fetch(`/api/search-asisten-manager?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(users => {
                        populateDropdown(users);
                    });
            } else if (query.length === 0) {
                // Show all when empty
                fetch(`/api/search-asisten-manager?q=`)
                    .then(response => response.json())
                    .then(users => {
                        populateDropdown(users);
                    });
            } else {
                divisiDropdown.classList.add('hidden');
            }
        }, 300);
    });

    function populateDropdown(users) {
        divisiDropdown.innerHTML = '';
        
        if (users.length === 0) {
            divisiDropdown.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ditemukan asisten manager</div>';
        } else {
            users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                div.dataset.userId = user.id;
                div.dataset.userName = user.name;
                div.dataset.divisiNama = user.divisi_nama;
                
                div.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">${user.name}</div>
                            <div class="text-xs text-gray-500">${user.divisi_nama} - ${user.jabatan}</div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                            Asmen
                        </span>
                    </div>
                `;
                
                div.addEventListener('click', () => {
                    // Set the display value to search input
                    divisiSearchInput.value = user.name;
                    // Store the actual divisi name in the hidden input
                    divisiTujuanInput.value = user.divisi_nama;
                    kepadaIdInput.value = user.id;
                    // Show selected text below
                    selectedDivisiText.textContent = `Dipilih: ${user.name} - ${user.divisi_nama}`;
                    divisiDropdown.classList.add('hidden');
                    clearSelectionBtn.classList.remove('hidden');
                });
                divisiDropdown.appendChild(div);
            });
        }
        divisiDropdown.classList.remove('hidden');
    }

    // Show dropdown when clicked
    divisiSearchInput.addEventListener('focus', function() {
        if (this.value === '') {
            fetch(`/api/search-asisten-manager?q=`)
                .then(response => response.json())
                .then(users => {
                    populateDropdown(users);
                });
        }
    });

    // Clear selection button
    clearSelectionBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        divisiSearchInput.value = '';
        divisiTujuanInput.value = '';
        kepadaIdInput.value = '';
        selectedDivisiText.textContent = '';
        this.classList.add('hidden');
        divisiDropdown.classList.add('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!divisiSearchInput.contains(e.target) && !divisiDropdown.contains(e.target)) {
            divisiDropdown.classList.add('hidden');
        }
    });

    // Form submission handler
    document.querySelector('form').addEventListener('submit', function(e) {
        // Ensure Quill content is saved to textarea before submission
        document.getElementById('isi_memo').value = quill.root.innerHTML;
        
        // Validate divisi selection
        if (!divisiTujuanInput.value) {
            e.preventDefault();
            alert('Silakan pilih divisi tujuan dari daftar asisten manager');
        }
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

/* Style untuk dropdown pencarian divisi */
#divisiDropdown {
    max-height: 300px;
    overflow-y: auto;
}

#divisiDropdown div {
    transition: background-color 0.2s;
}

#divisiDropdown div:hover {
    background-color: #f3f4f6;
}

/* Clear selection button */
#clearSelection {
    transition: color 0.2s;
}

/* Selected divisi text */
#selectedDivisiText {
    min-height: 1.25rem;
}
</style>
@endsection