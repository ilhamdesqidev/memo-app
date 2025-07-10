@extends('main')
@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 text-white p-10 rounded-2xl shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-blue-700 opacity-90"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2 flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Memo Baru
            </h1>
            <p class="text-blue-100">Isi formulir berikut untuk membuat memo baru dengan sistem yang profesional dan terstruktur</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 relative">
        <!-- Progress Bar -->
        <div class="bg-gray-100 h-1.5 rounded-full mb-8 overflow-hidden">
            <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-blue-800 transition-all duration-300" style="width: 0%"></div>
        </div>

        <form method="POST" action="{{ route('staff.memo.store') }}" enctype="multipart/form-data" class="p-8 sm:p-10">
            @csrf
            
            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nomor Memo -->
                <div class="space-y-2">
                    <label for="nomor" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Nomor Memo</label>
                    <input type="text" id="nomor" name="nomor" placeholder="Contoh: 001/DIR/2024" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-200">
                </div>
                
                <!-- Tanggal -->
                <div class="space-y-2">
                    <label for="tanggal" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-200">
                </div>
            </div>

            <!-- Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Kepada -->
                <div class="space-y-2">
                    <label for="kepada" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Kepada</label>
                    <input type="text" id="kepada" name="kepada" placeholder="Nama penerima memo" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-200">
                </div>
                
                <!-- Dari -->
                <div class="space-y-2">
                    <label for="dari" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Dari</label>
                    <input type="text" id="dari" name="dari" placeholder="Nama pengirim memo" required value="{{ Auth::user()->name }}" readonly
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 cursor-not-allowed">
                </div>
            </div>

            <!-- Perihal -->
            <div class="space-y-2 mb-6">
                <label for="perihal" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Perihal</label>
                <input type="text" id="perihal" name="perihal" placeholder="Subjek atau topik memo" required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-200">
            </div>

            <!-- Isi Memo -->
            <div class="space-y-2 mb-6">
                <label for="isi" class="block text-sm font-semibold text-blue-800 uppercase tracking-wider">Isi Memo</label>
                <textarea id="isi" name="isi" rows="6" placeholder="Tuliskan isi memo dengan jelas dan lengkap..." required
                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white transition-all duration-200"></textarea>
                <div id="charCounter" class="text-right text-sm text-gray-500 mt-1">0/2000 karakter</div>
            </div>

            <!-- Signature Upload -->
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 mb-6 bg-gray-50 hover:border-blue-500 hover:bg-gray-100 transition-all duration-200">
                <label class="block text-sm font-semibold text-blue-800 uppercase tracking-wider mb-3">Tanda Tangan Digital</label>
                <div id="signatureArea" class="text-center bg-white rounded-lg p-6 border border-gray-200 cursor-pointer hover:border-blue-500 hover:bg-gray-50 transition-all duration-200"
                     onclick="document.getElementById('signature').click()">
                    @if(Auth::user()->signature)
                        <img src="{{ asset('storage/' . Auth::user()->signature) }}" alt="Tanda Tangan" class="max-h-40 mx-auto">
                        <p class="mt-3 text-gray-600">Klik untuk mengganti tanda tangan</p>
                        <input type="hidden" name="use_profile_signature" value="1">
                    @else
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <p class="mt-3 text-gray-600">Klik untuk mengunggah tanda tangan digital (JPG, PNG, PDF)</p>
                    @endif
                    <input type="file" id="signature" name="signature" accept=".jpg,.jpeg,.png,.pdf" class="hidden">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 mt-8 border-t-2 border-gray-100">
                <a href="{{ route('staff.memo.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold shadow-md hover:from-red-600 hover:to-red-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold shadow-md hover:from-green-600 hover:to-green-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Memo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill current date
    const dateInput = document.getElementById('tanggal');
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    
    // Form progress tracking
    const formInputs = document.querySelectorAll('input[required], textarea[required]');
    const progressBar = document.getElementById('progressBar');
    
    function updateProgress() {
        let filledInputs = 0;
        formInputs.forEach(input => {
            if (input.value.trim() !== '') {
                filledInputs++;
            }
        });
        
        const progress = (filledInputs / formInputs.length) * 100;
        progressBar.style.width = progress + '%';
    }
    
    // Add event listeners to form inputs
    formInputs.forEach(input => {
        input.addEventListener('input', updateProgress);
        input.addEventListener('change', updateProgress);
    });
    
    // Initial progress update
    updateProgress();
    
    // Handle signature file input
    const signatureInput = document.getElementById('signature');
    const signatureArea = document.getElementById('signatureArea');
    
    signatureInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF');
                signatureInput.value = '';
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB');
                signatureInput.value = '';
                return;
            }
            
            // Preview image if it's an image file
            if (file.type.includes('image')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    signatureArea.innerHTML = `
                        <img src="${event.target.result}" alt="Preview Tanda Tangan" class="max-h-40 mx-auto">
                        <p class="mt-3 text-green-600 font-semibold">${fileName} (${fileSize} MB)</p>
                    `;
                    signatureArea.classList.add('border-green-500', 'bg-green-50');
                };
                reader.readAsDataURL(file);
            } else {
                signatureArea.innerHTML = `
                    <svg class="w-12 h-12 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-3 text-green-600 font-semibold">${fileName} (${fileSize} MB)</p>
                `;
                signatureArea.classList.add('border-green-500', 'bg-green-50');
            }
        } else {
            // If no file selected and user has profile signature, show that
            @if(Auth::user()->signature)
                signatureArea.innerHTML = `
                    <img src="{{ asset('storage/' . Auth::user()->signature) }}" alt="Tanda Tangan" class="max-h-40 mx-auto">
                    <p class="mt-3 text-gray-600">Klik untuk mengganti tanda tangan</p>
                    <input type="hidden" name="use_profile_signature" value="1">
                `;
            @else
                signatureArea.innerHTML = `
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <p class="mt-3 text-gray-600">Klik untuk mengunggah tanda tangan digital (JPG, PNG, PDF)</p>
                `;
            @endif
            signatureArea.classList.remove('border-green-500', 'bg-green-50');
        }
    });
    
    // Character counter for textarea
    const textarea = document.getElementById('isi');
    const charCounter = document.getElementById('charCounter');
    
    function updateCharCounter() {
        const length = textarea.value.length;
        const minLength = 50;
        const maxLength = 2000;
        
        charCounter.textContent = `${length}/${maxLength} karakter`;
        
        if (length < minLength) {
            charCounter.classList.add('text-red-500');
            charCounter.classList.remove('text-green-500');
            charCounter.textContent += ` (minimal ${minLength} karakter)`;
        } else if (length > maxLength) {
            charCounter.classList.add('text-red-500');
            charCounter.classList.remove('text-green-500');
            charCounter.textContent += ' (terlalu panjang)';
        } else {
            charCounter.classList.remove('text-red-500');
            charCounter.classList.add('text-green-500');
        }
    }
    
    textarea.addEventListener('input', updateCharCounter);
    updateCharCounter();
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        formInputs.forEach(input => {
            const formGroup = input.closest('.space-y-2');
            
            if (input.value.trim() === '') {
                formGroup.classList.add('error');
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-200', 'bg-gray-50');
                
                // Add error message if not exists
                if (!formGroup.querySelector('.error-message')) {
                    const error = document.createElement('p');
                    error.className = 'error-message text-red-500 text-sm mt-1';
                    error.textContent = 'Field ini wajib diisi';
                    formGroup.appendChild(error);
                }
                
                isValid = false;
            } else {
                formGroup.classList.remove('error');
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-200', 'bg-gray-50');
                
                // Remove error message if exists
                const errorMessage = formGroup.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection