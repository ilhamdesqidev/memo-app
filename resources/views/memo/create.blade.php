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
                            <div id="editor-container" style="height: 333px; background: white;"></div>
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
    // Define font sizes in numeric format (like Word)
    const Size = Quill.import('attributors/style/size');
    Size.whitelist = [
        '8px', '9px', '10px', '11px', '12px', '14px', '16px', 
        '18px', '20px', '24px', '28px', '32px', '36px', '48px'
    ];
    Quill.register(Size, true);

    // Define custom fonts including Times New Roman
    const Font = Quill.import('formats/font');
    Font.whitelist = [
        'arial', 
        'times-new-roman', 
        'georgia', 
        'verdana', 
        'courier-new',
        'tahoma',
        'impact'
    ];
    Quill.register(Font, true);

    // Initialize Quill Editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    // Font family and size
                    [{ 'font': Font.whitelist }],
                    [{ 'size': Size.whitelist }],
                    
                    // Text formatting
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    
                    // Lists and indentation
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    
                    // Headers and alignment
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'align': [] }],
                    
                    // Script and blocks
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    ['blockquote', 'code-block'],
                    
                    // Media and clean
                    ['link'],
                    ['clean']
                ]
            }
        },
        placeholder: 'Tulis isi memo di sini...',
        bounds: '#editor-container'
    });

    // Set default font to Times New Roman
    quill.format('font', 'times-new-roman');

    // Set initial content if exists
    var initialContent = document.getElementById('isi_memo').value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    // Update hidden textarea when content changes
    quill.on('text-change', function() {
        document.getElementById('isi_memo').value = quill.root.innerHTML;
    });

    // Divisi Tujuan search functionality (only for asisten_manager from other divisions)
    const divisiSearchInput = document.getElementById('divisi_search');
    const divisiTujuanInput = document.getElementById('divisi_tujuan');
    const kepadaIdInput = document.getElementById('kepada_id');
    const divisiDropdown = document.getElementById('divisiDropdown');
    const clearSelectionBtn = document.getElementById('clearSelection');
    const selectedDivisiText = document.getElementById('selectedDivisiText');

    // Get current divisi from user data
    const currentDivisi = '{{ auth()->user()->divisi->nama }}';

    // Search functionality with debounce
    let searchTimeout;
    divisiSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                fetch(`/api/search-asisten-manager?q=${encodeURIComponent(query)}&current_divisi=${encodeURIComponent(currentDivisi)}`)
                    .then(response => response.json())
                    .then(users => {
                        populateDropdown(users);
                    });
            } else if (query.length === 0) {
                // Show all asisten managers from other divisions when empty
                fetch(`/api/search-asisten-manager?q=&current_divisi=${encodeURIComponent(currentDivisi)}`)
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
            divisiDropdown.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ditemukan asisten manager dari divisi lain</div>';
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

    // Show dropdown when clicked (only showing asisten managers from other divisions)
    divisiSearchInput.addEventListener('focus', function() {
        if (this.value === '') {
            fetch(`/api/search-asisten-manager?q=&current_divisi=${encodeURIComponent(currentDivisi)}`)
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
    font-family: "Times New Roman", Times, serif;
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

/* Font family customizations */
.ql-font-times-new-roman {
    font-family: "Times New Roman", Times, serif !important;
}

.ql-font-arial {
    font-family: Arial, Helvetica, sans-serif !important;
}

.ql-font-georgia {
    font-family: Georgia, serif !important;
}

.ql-font-verdana {
    font-family: Verdana, Geneva, sans-serif !important;
}

.ql-font-courier-new {
    font-family: "Courier New", Courier, monospace !important;
}

.ql-font-tahoma {
    font-family: Tahoma, Geneva, sans-serif !important;
}

.ql-font-impact {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif !important;
}

/* Fix for font size dropdown */
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="8px"]::before {
    content: '8px';
    font-size: 8px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="9px"]::before {
    content: '9px';
    font-size: 9px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="10px"]::before {
    content: '10px';
    font-size: 10px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="11px"]::before {
    content: '11px';
    font-size: 11px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="12px"]::before {
    content: '12px';
    font-size: 12px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="14px"]::before {
    content: '14px';
    font-size: 14px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="16px"]::before {
    content: '16px';
    font-size: 16px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="18px"]::before {
    content: '18px';
    font-size: 18px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="20px"]::before {
    content: '20px';
    font-size: 20px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="24px"]::before {
    content: '24px';
    font-size: 24px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="28px"]::before {
    content: '28px';
    font-size: 28px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="32px"]::before {
    content: '32px';
    font-size: 32px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="36px"]::before {
    content: '36px';
    font-size: 36px !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="48px"]::before {
    content: '48px';
    font-size: 48px !important;
}

/* Selected value in dropdown */
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="8px"]::before {
    content: '8px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="9px"]::before {
    content: '9px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="10px"]::before {
    content: '10px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="11px"]::before {
    content: '11px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="12px"]::before {
    content: '12px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="14px"]::before {
    content: '14px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="16px"]::before {
    content: '16px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="18px"]::before {
    content: '18px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="20px"]::before {
    content: '20px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="24px"]::before {
    content: '24px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="28px"]::before {
    content: '28px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="32px"]::before {
    content: '32px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="36px"]::before {
    content: '36px';
    font-size: 12px;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="48px"]::before {
    content: '48px';
    font-size: 12px;
}

/* Fix font dropdown */
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="times-new-roman"]::before {
    content: "Times New Roman";
    font-family: "Times New Roman", Times, serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="arial"]::before {
    content: "Arial";
    font-family: Arial, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="georgia"]::before {
    content: "Georgia";
    font-family: Georgia, serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="verdana"]::before {
    content: "Verdana";
    font-family: Verdana, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="courier-new"]::before {
    content: "Courier New";
    font-family: "Courier New", monospace;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="tahoma"]::before {
    content: "Tahoma";
    font-family: Tahoma, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="impact"]::before {
    content: "Impact";
    font-family: Impact, sans-serif;
}

.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="times-new-roman"]::before {
    content: "Times New Roman";
    font-family: "Times New Roman", Times, serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="arial"]::before {
    content: "Arial";
    font-family: Arial, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="georgia"]::before {
    content: "Georgia";
    font-family: Georgia, serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="verdana"]::before {
    content: "Verdana";
    font-family: Verdana, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="courier-new"]::before {
    content: "Courier New";
    font-family: "Courier New", monospace;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="tahoma"]::before {
    content: "Tahoma";
    font-family: Tahoma, sans-serif;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="impact"]::before {
    content: "Impact";
    font-family: Impact, sans-serif;
}

/* Ensure font styles are applied correctly in the editor */
.ql-editor .ql-font-times-new-roman {
    font-family: "Times New Roman", Times, serif !important;
}

.ql-editor .ql-font-arial {
    font-family: Arial, Helvetica, sans-serif !important;
}

.ql-editor .ql-font-georgia {
    font-family: Georgia, serif !important;
}

.ql-editor .ql-font-verdana {
    font-family: Verdana, Geneva, sans-serif !important;
}

.ql-editor .ql-font-courier-new {
    font-family: "Courier New", Courier, monospace !important;
}

.ql-editor .ql-font-tahoma {
    font-family: Tahoma, Geneva, sans-serif !important;
}

.ql-editor .ql-font-impact {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif !important;
}

/* Make sure font sizes are applied correctly */
.ql-editor .ql-size-8px {
    font-size: 8px !important;
}
.ql-editor .ql-size-9px {
    font-size: 9px !important;
}
.ql-editor .ql-size-10px {
    font-size: 10px !important;
}
.ql-editor .ql-size-11px {
    font-size: 11px !important;
}
.ql-editor .ql-size-12px {
    font-size: 12px !important;
}
.ql-editor .ql-size-14px {
    font-size: 14px !important;
}
.ql-editor .ql-size-16px {
    font-size: 16px !important;
}
.ql-editor .ql-size-18px {
    font-size: 18px !important;
}
.ql-editor .ql-size-20px {
    font-size: 20px !important;
}
.ql-editor .ql-size-24px {
    font-size: 24px !important;
}
.ql-editor .ql-size-28px {
    font-size: 28px !important;
}
.ql-editor .ql-size-32px {
    font-size: 32px !important;
}
.ql-editor .ql-size-36px {
    font-size: 36px !important;
}
.ql-editor .ql-size-48px {
    font-size: 48px !important;
}
</style>
@endsection