@extends('main')
@section('content')
<style>
    .memo-detail-container {
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
    
    .memo-detail-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .memo-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6 0%, #1e40af 100%);
    }
    
    .memo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
    }
    
    .memo-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e40af;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 8px 20px;
        border-radius: 20px;
        border: 1px solid #93c5fd;
    }
    
    .memo-date {
        font-size: 1rem;
        color: #6b7280;
        font-weight: 500;
        background: #f9fafb;
        padding: 8px 20px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
    }
    
    .memo-detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }
    
    .memo-detail-field {
        margin-bottom: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 15px;
        border-left: 3px solid #3b82f6;
    }
    
    .memo-detail-field strong {
        color: #1e40af;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    
    .memo-detail-field span {
        color: #374151;
        font-size: 1.1rem;
        font-weight: 500;
        line-height: 1.6;
    }
    
    .memo-content {
        margin: 30px 0;
        padding: 30px;
        background: #f8fafc;
        border-radius: 15px;
        border: 1px solid #e5e7eb;
        white-space: pre-line;
    }
    
    .memo-content-title {
        color: #1e40af;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .signature-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #f3f4f6;
    }
    
    .signature-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }
    
    .signature-box {
        text-align: center;
        max-width: 300px;
    }
    
    .signature-image {
        max-width: 100%;
        max-height: 150px;
        margin-bottom: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 5px;
    }
    
    .signature-name {
        font-weight: 600;
        color: #1e40af;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e5e7eb;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }
    
    .btn {
        padding: 12px 24px;
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
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .memo-detail-container {
            padding: 15px;
        }
        
        .header {
            padding: 2rem 1.5rem;
        }
        
        .header h1 {
            font-size: 1.8rem;
        }
        
        .memo-detail-card {
            padding: 25px;
        }
        
        .memo-detail-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
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
</style>

<div class="memo-detail-container loading">
    <div class="header">
        <h1><i class="fas fa-file-alt"></i> Detail Memo</h1>
        <p>Lihat informasi lengkap tentang memo ini termasuk tanda tangan digital</p>
    </div>

    <div class="memo-detail-card">
        <div class="memo-header">
            <div class="memo-number">{{ $memo->nomor }}</div>
            <div class="memo-date">{{ \Carbon\Carbon::parse($memo->tanggal)->format('d F Y') }}</div>
        </div>

        <div class="memo-detail-row">
            <div class="memo-detail-field">
                <strong>Kepada</strong>
                <span>{{ $memo->kepada }}</span>
            </div>
            <div class="memo-detail-field">
                <strong>Dari</strong>
                <span>{{ $memo->dari }}</span>
            </div>
        </div>

        <div class="memo-detail-field">
            <strong>Perihal</strong>
            <span>{{ $memo->perihal }}</span>
        </div>

        <div class="memo-content">
            <div class="memo-content-title">Isi Memo</div>
            <p>{{ $memo->isi }}</p>
        </div>

        @if($memo->signature)
        <div class="signature-section">
            <div class="memo-detail-field">
                <strong>Tanda Tangan Digital</strong>
                <div class="signature-container">
                    <div class="signature-box">
                        @if(pathinfo($memo->signature, PATHINFO_EXTENSION) === 'pdf')
                            <embed src="{{ asset('storage/' . $memo->signature) }}" type="application/pdf" width="250" height="150">
                        @else
                            <img src="{{ asset('storage/' . $memo->signature) }}" alt="Tanda Tangan" class="signature-image">
                        @endif
                        <div class="signature-name">{{ $memo->dari }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="action-buttons">
            <a href="{{ route('staff.memo.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('staff.memo.edit', $memo->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('staff.memo.destroy', $memo->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus memo ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation for elements
    const elements = document.querySelectorAll('.memo-header, .memo-detail-row, .memo-detail-field, .memo-content, .signature-section');
    elements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
        el.classList.add('loading');
    });

    // Print functionality
    const printButton = document.createElement('button');
    printButton.className = 'btn btn-primary';
    printButton.innerHTML = '<i class="fas fa-print"></i> Cetak';
    printButton.style.marginRight = 'auto';
    printButton.onclick = function() {
        window.print();
    };
    
    document.querySelector('.action-buttons').prepend(printButton);

    // Add CSS for animations
    const additionalCSS = `
        .memo-header.loading,
        .memo-detail-row.loading,
        .memo-detail-field.loading,
        .memo-content.loading,
        .signature-section.loading {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media print {
            .header, .action-buttons {
                display: none;
            }
            
            .memo-detail-card {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            
            .memo-detail-field {
                page-break-inside: avoid;
            }
            
            .signature-image {
                max-height: 100px;
            }
        }
    `;

    const style = document.createElement('style');
    style.textContent = additionalCSS;
    document.head.appendChild(style);
});
</script>

@endsection