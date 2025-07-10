@extends('main')
@section('content')

<style>
    .memo-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 15px 40px rgba(30, 60, 114, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .memo-form {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }
    
    .memo-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6 0%, #1e40af 100%);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #374151;
        box-sizing: border-box;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .form-group textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }
    
    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #9ca3af;
        opacity: 1;
    }
    
    .signature-upload {
        margin-bottom: 25px;
        padding: 25px;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .signature-upload:hover {
        border-color: #3b82f6;
        background: #f1f5f9;
    }
    
    .signature-upload label {
        display: block;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 12px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .signature-area {
        text-align: center;
        padding: 30px;
        background: white;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .signature-area:hover {
        border-color: #3b82f6;
        background: #f9fafb;
    }
    
    .signature-area i {
        font-size: 2.5rem;
        color: #6b7280;
        margin-bottom: 15px;
    }
    
    .signature-area p {
        color: #6b7280;
        margin: 0;
        font-weight: 500;
    }
    
    .signature-area input {
        display: none;
    }
    
    .signature-preview {
        max-width: 100%;
        max-height: 150px;
        display: block;
        margin: 0 auto;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid #f3f4f6;
    }
    
    .btn {
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: translateY(0);
        min-width: 140px;
        justify-content: center;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    /* Enhanced Form Validation Styles */
    .form-group.error input,
    .form-group.error select,
    .form-group.error textarea {
        border-color: #ef4444;
        background: #fef2f2;
    }
    
    .form-group.error input:focus,
    .form-group.error select:focus,
    .form-group.error textarea:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 5px;
        font-weight: 500;
    }
    
    /* Success State */
    .form-group.success input,
    .form-group.success select,
    .form-group.success textarea {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .success-message {
        color: #10b981;
        font-size: 0.85rem;
        margin-top: 5px;
        font-weight: 500;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .memo-container {
            padding: 15px;
        }
        
        .header {
            padding: 2rem 1.5rem;
        }
        
        .header h1 {
            font-size: 1.8rem;
        }
        
        .memo-form {
            padding: 25px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    
    /* Loading Animation */
    .loading {
        opacity: 0;
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Form Progress Indicator */
    .form-progress {
        background: #f3f4f6;
        height: 4px;
        border-radius: 2px;
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .form-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6 0%, #1e40af 100%);
        width: 0%;
        transition: width 0.3s ease;
    }
</style>

<div class="memo-container loading">
    <div class="header">
        <h1><i class="fas fa-plus-circle"></i> Buat Memo Baru</h1>
        <p>Isi formulir berikut untuk membuat memo baru dengan sistem yang profesional dan terstruktur</p>
    </div>

    <div class="memo-form">
        <div class="form-progress">
            <div class="form-progress-bar" id="progressBar"></div>
        </div>
        
        <form method="POST" action="{{ route('staff.memo.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="nomor">Nomor Memo</label>
                    <input type="text" id="nomor" name="nomor" placeholder="Contoh: 001/DIR/2024" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kepada">Kepada</label>
                    <input type="text" id="kepada" name="kepada" placeholder="Nama penerima memo" required>
                </div>
                <div class="form-group">
                    <label for="dari">Dari</label>
                    <input type="text" id="dari" name="dari" placeholder="Nama pengirim memo" required value="{{ Auth::user()->name }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="perihal">Perihal</label>
                <input type="text" id="perihal" name="perihal" placeholder="Subjek atau topik memo" required>
            </div>

            <div class="form-group">
                <label for="isi">Isi Memo</label>
                <textarea id="isi" name="isi" placeholder="Tuliskan isi memo dengan jelas dan lengkap..." required></textarea>
            </div>

            <div class="signature-upload">
                <label for="signature">Tanda Tangan Digital</label>
                <div class="signature-area" onclick="document.getElementById('signature').click()">
                    @if(Auth::user()->signature)
                        <img src="{{ asset('storage/' . Auth::user()->signature) }}" alt="Tanda Tangan" class="signature-preview">
                        <p class="mt-2">Klik untuk mengganti tanda tangan</p>
                        <input type="hidden" name="use_profile_signature" value="1">
                    @else
                        <i class="fas fa-signature"></i>
                        <p>Klik untuk mengunggah tanda tangan digital (JPG, PNG, PDF)</p>
                    @endif
                    <input type="file" id="signature" name="signature" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('staff.memo.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Memo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Document ready
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.memo-container');
    container.classList.add('loading');
    
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
    
    // Enhanced form validation
    function validateForm() {
        let isValid = true;
        
        formInputs.forEach(input => {
            const formGroup = input.closest('.form-group');
            const errorMessage = formGroup.querySelector('.error-message');
            
            if (input.value.trim() === '') {
                formGroup.classList.add('error');
                formGroup.classList.remove('success');
                
                if (!errorMessage) {
                    const error = document.createElement('div');
                    error.className = 'error-message';
                    error.textContent = 'Field ini wajib diisi';
                    formGroup.appendChild(error);
                }
                
                isValid = false;
            } else {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
                
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
        
        return isValid;
    }
    
    // Handle signature file input
    const signatureInput = document.getElementById('signature');
    const signatureArea = document.querySelector('.signature-area');
    
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
                        <img src="${event.target.result}" alt="Preview Tanda Tangan" class="signature-preview">
                        <p style="color: #10b981; margin: 5px 0 0 0; font-weight: 600;">${fileName} (${fileSize} MB)</p>
                    `;
                    signatureArea.style.borderColor = '#10b981';
                    signatureArea.style.background = '#f0fdf4';
                };
                reader.readAsDataURL(file);
            } else {
                signatureArea.innerHTML = `
                    <i class="fas fa-file-pdf" style="color: #10b981; font-size: 2.5rem; margin-bottom: 15px;"></i>
                    <p style="color: #10b981; margin: 0; font-weight: 600;">${fileName} (${fileSize} MB)</p>
                `;
                signatureArea.style.borderColor = '#10b981';
                signatureArea.style.background = '#f0fdf4';
            }
        } else {
            // If no file selected and user has profile signature, show that
            @if(Auth::user()->signature)
                signatureArea.innerHTML = `
                    <img src="{{ asset('storage/' . Auth::user()->signature) }}" alt="Tanda Tangan" class="signature-preview">
                    <p class="mt-2">Klik untuk mengganti tanda tangan</p>
                    <input type="hidden" name="use_profile_signature" value="1">
                `;
            @else
                signatureArea.innerHTML = `
                    <i class="fas fa-signature"></i>
                    <p>Klik untuk mengunggah tanda tangan digital (JPG, PNG, PDF)</p>
                `;
            @endif
            signatureArea.style.borderColor = '#e5e7eb';
            signatureArea.style.background = 'white';
        }
    });
    
    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    const autoSaveInputs = document.querySelectorAll('input, textarea');
    
    function autoSave() {
        const formData = {};
        autoSaveInputs.forEach(input => {
            if (input.type !== 'file') {
                formData[input.name] = input.value;
            }
        });
        
        // Save to localStorage (in a real application, you'd save to server)
        localStorage.setItem('memo_draft', JSON.stringify(formData));
        
        // Show auto-save indicator
        const indicator = document.createElement('div');
        indicator.innerHTML = '<i class="fas fa-save"></i> Draft disimpan otomatis';
        indicator.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(indicator);
        
        setTimeout(() => {
            indicator.remove();
        }, 2000);
    }
    
    // Auto-save every 30 seconds
    autoSaveInputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(autoSave, 30000);
        });
    });
    
    // Load draft on page load
    const savedDraft = localStorage.getItem('memo_draft');
    if (savedDraft) {
        const draftData = JSON.parse(savedDraft);
        Object.keys(draftData).forEach(key => {
            const input = document.querySelector(`[name="${key}"]`);
            if (input && input.type !== 'file') {
                input.value = draftData[key];
            }
        });
        updateProgress();
    }
    
    // Clear draft on successful submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('memo_draft');
    });
    
    // Character counter for textarea
    const textarea = document.getElementById('isi');
    const charCounter = document.createElement('div');
    charCounter.style.cssText = `
        text-align: right;
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 5px;
    `;
    textarea.parentNode.appendChild(charCounter);
    
    function updateCharCounter() {
        const length = textarea.value.length;
        const minLength = 50;
        const maxLength = 2000;
        
        charCounter.textContent = `${length}/${maxLength} karakter`;
        
        if (length < minLength) {
            charCounter.style.color = '#ef4444';
            charCounter.textContent += ` (minimal ${minLength} karakter)`;
        } else if (length > maxLength) {
            charCounter.style.color = '#ef4444';
            charCounter.textContent += ' (terlalu panjang)';
        } else {
            charCounter.style.color = '#10b981';
        }
    }
    
    textarea.addEventListener('input', updateCharCounter);
    updateCharCounter();
    
    // Smooth transitions for form groups
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        group.style.animationDelay = `${index * 0.1}s`;
        group.classList.add('loading');
    });
});

// Add CSS for additional animations
const additionalCSS = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .form-group.loading {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;

const style = document.createElement('style');
style.textContent = additionalCSS;
document.head.appendChild(style);
</script>

@endsection