@extends('main')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('staff.memo.index') }}" class="text-gray-600 hover:text-gray-800 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Memo</h2>
            </div>
            <p class="text-gray-600">Perbarui informasi memo yang sudah ada</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Detail Memo</h3>
                <p class="text-sm text-gray-600 mt-1">Lengkapi form berikut untuk mengedit memo</p>
            </div>

            <form method="POST" action="{{ route('staff.memo.update', $memo->id) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Memo Information Section -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-900 border-b border-gray-200 pb-2">Informasi Memo</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nomor Memo -->
                        <div class="md:col-span-1">
                            <label for="nomor" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Memo
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nomor" 
                                   name="nomor" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('nomor') border-red-500 @enderror" 
                                   value="{{ old('nomor', $memo->nomor) }}"
                                   placeholder="Masukkan nomor memo">
                            @error('nomor') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="md:col-span-1">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('tanggal') border-red-500 @enderror" 
                                   value="{{ old('tanggal', \Carbon\Carbon::parse($memo->tanggal)->format('Y-m-d')) }}">
                            @error('tanggal') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kepada -->
                        <div class="md:col-span-1">
                            <label for="kepada" class="block text-sm font-medium text-gray-700 mb-2">
                                Kepada
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="kepada" 
                                   name="kepada" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('kepada') border-red-500 @enderror" 
                                   value="{{ old('kepada', $memo->kepada) }}"
                                   placeholder="Masukkan penerima memo">
                            @error('kepada') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <!-- Dari -->
                        <div class="md:col-span-1">
                            <label for="dari" class="block text-sm font-medium text-gray-700 mb-2">
                                Dari
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="dari" 
                                   name="dari" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('dari') border-red-500 @enderror" 
                                   value="{{ old('dari', $memo->dari) }}"
                                   placeholder="Masukkan pengirim memo">
                            @error('dari') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Perihal -->
                    <div>
                        <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
                            Perihal
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="perihal" 
                               name="perihal" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('perihal') border-red-500 @enderror" 
                               value="{{ old('perihal', $memo->perihal) }}"
                               placeholder="Masukkan perihal memo">
                        @error('perihal') 
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Isi Memo -->
                    <div>
                        <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                            Isi Memo
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="isi" 
                                  name="isi" 
                                  rows="4" 
                                  required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('isi') border-red-500 @enderror" 
                                  placeholder="Tulis isi memo disini">{{ old('isi', $memo->isi) }}</textarea>
                        @error('isi') 
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Tanda Tangan -->
                    <div>
                        <label for="signature" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanda Tangan
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            @if($memo->signature)
                                <div class="signature-area">
                                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                    <p style="color: #28a745;">Tanda tangan sudah diunggah</p>
                                </div>
                            @else
                                <div class="signature-area">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mt-1 text-sm text-gray-600">Upload tanda tangan (format .png)</p>
                                </div>
                            @endif
                            <input type="file" 
                                   id="signature" 
                                   name="signature" 
                                   class="sr-only"
                                   accept="image/png">
                            <button type="button" 
                                    onclick="document.getElementById('signature').click()" 
                                    class="mt-2 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Pilih File
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('staff.memo.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle signature file input
document.getElementById('signature').addEventListener('change', function(e) {
    const signatureArea = document.querySelector('.signature-area');
    if (e.target.files.length > 0) {
        signatureArea.innerHTML = `
            <i class="fas fa-check-circle" style="color: #28a745;"></i>
            <p style="color: #28a745;">Tanda tangan berhasil diunggah: ${e.target.files[0].name}</p>
        `;
    }
});
</script>
@endsection