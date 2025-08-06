@extends('layouts.divisi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Memo</h1>
            <p class="text-gray-600 mt-1">Perbarui memo untuk komunikasi antar divisi</p>
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
        <form action="{{ route($routePrefix . '.memo.update', $memo->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Memo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Memo *</label>
                        <input type="text" name="nomor" value="{{ old('nomor', $memo->nomor) }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal *</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $memo->tanggal) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Kepada -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Kepada *</label>
                        <input type="text" id="kepada_search" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Cari nama penerima..." 
                               value="{{ $memo->kepada }} ({{ $memo->divisi_tujuan }})"
                               autocomplete="off">
                        <input type="hidden" name="kepada" id="kepada" value="{{ old('kepada', $memo->kepada) }}">
                        <input type="hidden" name="kepada_id" id="kepada_id" value="{{ old('kepada_id', $memo->kepada_id) }}">
                        <div id="kepadaDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"></div>
                    </div>

                    <!-- Dari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari</label>
                        <input type="text" value="{{ $memo->dari }}" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <input type="hidden" name="dari" value="{{ $memo->dari }}">
                    </div>

                    <!-- Perihal -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Perihal *</label>
                        <input type="text" name="perihal" value="{{ old('perihal', $memo->perihal) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Divisi Tujuan -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Divisi Tujuan *</label>
                        <input type="text" name="divisi_tujuan" id="divisi_tujuan" 
                               value="{{ old('divisi_tujuan', $memo->divisi_tujuan) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Isi Memo dengan Rich Text Editor -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Isi Memo *</label>
                        <div class="mt-1">
                            <!-- Quill Editor Container -->
                            <div id="editor-container" style="height: 300px; background: white;">{!! old('isi', $memo->isi) !!}</div>
                            <!-- Hidden textarea for form submission -->
                            <textarea name="isi" id="isi_memo" style="display: none;" required>{{ old('isi', $memo->isi) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route($routePrefix . '.memo.index') }}" 
                       class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
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
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Tulis isi memo di sini...',
        bounds: '#editor-container'
    });

    // Set initial content from hidden textarea
    quill.root.innerHTML = document.getElementById('isi_memo').value;

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

    // Load selected user data
    const selectedUserId = kepadaIdInput.value;
    if (selectedUserId) {
        fetch(`/api/search-users?id=${selectedUserId}`)
            .then(response => response.json())
            .then(user => {
                if (user) {
                    searchInput.value = `${user.name} (${user.divisi_nama})`;
                    kepadaInput.value = user.name;
                    kepadaIdInput.value = user.id;
                    divisiInput.value = user.divisi_nama;
                }
            });
    }

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
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium">${user.name}</div>
                                    <div class="text-xs text-gray-500">${user.divisi_nama}</div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    ${user.role === 'asisten_manager' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'}">
                                    ${user.role === 'asisten_manager' ? 'Asmen' : 'User'}
                                </span>
                            </div>
                        `;
                        
                        div.addEventListener('click', () => {
                            searchInput.value = `${user.name} (${user.divisi_nama})`;
                            kepadaInput.value = user.name;
                            kepadaIdInput.value = user.id;
                            
                            // Jika penerima adalah asisten manager, set divisi tujuan ke divisi asisten manager tersebut
                            if (user.role === 'asisten_manager') {
                                divisiInput.value = user.divisi_nama;
                            } else {
                                divisiInput.value = user.divisi_nama;
                            }
                            
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
        
        // Validate recipient selection
        if (!kepadaIdInput.value) {
            e.preventDefault();
            alert('Silakan pilih penerima memo dari daftar');
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

/* Style untuk dropdown pencarian user */
#kepadaDropdown {
    max-height: 300px;
    overflow-y: auto;
}

#kepadaDropdown div {
    transition: background-color 0.2s;
}

#kepadaDropdown div:hover {
    background-color: #f3f4f6;
}
</style>
@endsection