@extends('main')

@section('content')
<style>
    .memo-container {
        width: 100%;
        padding: 1.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
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
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .header p {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .memo-actions {
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 2px dashed #e5e7eb;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        color: #374151;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #6b7280;
        font-size: 0.875rem;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .memo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .memo-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #3b82f6;
        position: relative;
        overflow: hidden;
    }
    
    .memo-card::before {
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
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .memo-number {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e40af;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        border: 1px solid #93c5fd;
    }
    
    .memo-date {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
        background: #f9fafb;
        padding: 0.25rem 0.5rem;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
    }
    
    .memo-info {
        margin-bottom: 1.5rem;
    }
    
    .memo-field {
        display: flex;
        flex-direction: column;
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 0.5rem;
        border-left: 3px solid #3b82f6;
    }
    
    .memo-field strong {
        color: #1e40af;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .memo-field span {
        color: #374151;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.4;
    }
    
    .card-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .card-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.375rem;
        flex: 1;
        min-width: 60px;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .memo-container {
            padding: 1rem;
        }
        
        .header {
            padding: 1rem;
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .memo-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="memo-container">
    <div class="header">
        <h1><i class="fas fa-file-alt mr-2"></i> Sistem Memo</h1>
        <p>Kelola surat-menyurat dan memo perusahaan dengan sistem yang profesional dan efisien</p>
    </div>

    <div class="memo-actions">
        <a href="{{ route('staff.memo.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Buat Memo Baru
        </a>
    </div>

    @if($memos->isEmpty())
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>Tidak Ada Memo</h3>
            <p>Belum ada memo yang tersedia. Klik "Buat Memo Baru" untuk membuat memo pertama Anda.</p>
        </div>
    @else
        <div class="memo-grid">
            @foreach($memos as $memo)
                <div class="memo-card">
                    <div class="memo-header">
                        <div class="memo-number">{{ $memo->nomor }}</div>
                       <div class="memo-date">{{ $memo->tanggal->format('d M Y') }}</div>
                    </div>
                    <div class="memo-info">
                        <div class="memo-field">
                            <strong>Kepada:</strong>
                            <span>{{ $memo->kepada }}</span>
                        </div>
                        <div class="memo-field">
                            <strong>Dari:</strong>
                            <span>{{ $memo->dari }}</span>
                        </div>
                        <div class="memo-field">
                            <strong>Perihal:</strong>
                            <span>{{ $memo->perihal }}</span>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('staff.memo.show', $memo->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye mr-1"></i> Lihat
                        </a>
                        <a href="{{ route('staff.memo.edit', $memo->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('staff.memo.destroy', $memo->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus memo ini?')">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to memo cards
    document.querySelectorAll('.memo-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 15px 40px rgba(59, 130, 246, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.08)';
        });
    });
});
</script>
@endsection