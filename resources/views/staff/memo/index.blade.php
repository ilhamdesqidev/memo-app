@extends('main')
@section('content')

<style>
    .memo-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        text-align: center;
    }

    .header p {
        text-align: center;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .nav-tabs {
        display: flex;
        background: white;
        border-radius: 10px;
        padding: 5px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .nav-tab {
        flex: 1;
        padding: 15px 20px;
        text-align: center;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .nav-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .nav-tab:hover:not(.active) {
        background: #f8f9fa;
        transform: translateY(-1px);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* INDEX STYLES */
    .memo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    .memo-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-left: 5px solid #667eea;
    }

    .memo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .memo-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .memo-number {
        background: #667eea;
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .memo-date {
        color: #666;
        font-size: 0.9rem;
    }

    .memo-info {
        margin-bottom: 15px;
    }

    .memo-field {
        margin-bottom: 8px;
        display: flex;
        align-items: start;
    }

    .memo-field strong {
        min-width: 80px;
        color: #333;
        font-weight: 600;
    }

    .memo-field span {
        color: #666;
        flex: 1;
    }

    .memo-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
    }

    .memo-content h4 {
        margin-bottom: 10px;
        color: #333;
    }

    .memo-content p {
        line-height: 1.6;
        color: #555;
    }

    .memo-signature {
        text-align: right;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .memo-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5a6fd8;
        transform: translateY(-2px);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-warning {
        background: #ffc107;
        color: #333;
    }

    .btn-warning:hover {
        background: #e0a800;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    /* CREATE FORM STYLES */
    .memo-form {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
    }

    .form-group.full-width {
        width: 100%;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .signature-area {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        margin: 20px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .signature-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .signature-area i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 15px;
    }

    .signature-area p {
        color: #666;
        font-size: 1.1rem;
        margin: 0;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        color: #333;
    }

    .empty-state p {
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .search-box {
        max-width: 400px;
        margin: 0 auto 30px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-box i {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    @media (max-width: 768px) {
        .nav-tabs {
            flex-direction: column;
            gap: 5px;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .memo-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="memo-container">
    <div class="header">
        <h1><i class="fas fa-file-alt"></i> Sistem Memo</h1>
        <p>Kelola surat-menyurat dan memo perusahaan dengan mudah</p>
    </div>

    <div class="nav-tabs">
        <div class="nav-tab active" onclick="showTab('index')">
            <i class="fas fa-list"></i>
            Daftar Memo
        </div>
        <div class="nav-tab" onclick="showTab('create')">
            <i class="fas fa-plus"></i>
            Buat Memo Baru
        </div>
    </div>

    <!-- INDEX TAB -->
    <div id="index" class="tab-content active">
        <div class="search-box">
            <input type="text" placeholder="Cari memo berdasarkan nomor, perihal, atau pengirim...">
            <i class="fas fa-search"></i>
        </div>

        <div class="memo-grid">
            <!-- Sample Memo Card 1 -->
            <div class="memo-card">
                <div class="memo-header">
                    <div class="memo-number">001/DIR/2024</div>
                    <div class="memo-date">08 Juli 2025</div>
                </div>
                <div class="memo-info">
                    <div class="memo-field">
                        <strong>Kepada:</strong>
                        <span>Kepala Bagian HRD</span>
                    </div>
                    <div class="memo-field">
                        <strong>Dari:</strong>
                        <span>Direktur Utama</span>
                    </div>
                    <div class="memo-field">
                        <strong>Perihal:</strong>
                        <span>Evaluasi Kinerja Karyawan Q2 2025</span>
                    </div>
                    <div class="memo-field">
                        <strong>Lampiran:</strong>
                        <span>2 berkas</span>
                    </div>
                </div>
                <div class="memo-content">
                    <h4>Isi Memo:</h4>
                    <p>Dengan hormat, dalam rangka evaluasi kinerja karyawan untuk kuartal kedua tahun 2025, dimohon untuk mempersiapkan laporan evaluasi...</p>
                </div>
                <div class="memo-signature">
                    <strong>Direktur Utama</strong><br>
                    <em>Ahmad Wijaya</em>
                </div>
                <div class="memo-actions">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="#" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="#" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>

            <!-- Sample Memo Card 2 -->
            <div class="memo-card">
                <div class="memo-header">
                    <div class="memo-number">002/IT/2024</div>
                    <div class="memo-date">07 Juli 2025</div>
                </div>
                <div class="memo-info">
                    <div class="memo-field">
                        <strong>Kepada:</strong>
                        <span>Seluruh Staff IT</span>
                    </div>
                    <div class="memo-field">
                        <strong>Dari:</strong>
                        <span>Kepala Divisi IT</span>
                    </div>
                    <div class="memo-field">
                        <strong>Perihal:</strong>
                        <span>Pemeliharaan Server Mingguan</span>
                    </div>
                    <div class="memo-field">
                        <strong>Lampiran:</strong>
                        <span>1 berkas</span>
                    </div>
                </div>
                <div class="memo-content">
                    <h4>Isi Memo:</h4>
                    <p>Kepada seluruh staff IT, diberitahukan bahwa akan dilakukan pemeliharaan server rutin setiap hari Minggu mulai pukul 02:00 WIB...</p>
                </div>
                <div class="memo-signature">
                    <strong>Kepala Divisi IT</strong><br>
                    <em>Budi Santoso</em>
                </div>
                <div class="memo-actions">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="#" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="#" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>

            <!-- Sample Memo Card 3 -->
            <div class="memo-card">
                <div class="memo-header">
                    <div class="memo-number">003/FIN/2024</div>
                    <div class="memo-date">06 Juli 2025</div>
                </div>
                <div class="memo-info">
                    <div class="memo-field">
                        <strong>Kepada:</strong>
                        <span>Kepala Bagian Accounting</span>
                    </div>
                    <div class="memo-field">
                        <strong>Dari:</strong>
                        <span>Manajer Keuangan</span>
                    </div>
                    <div class="memo-field">
                        <strong>Perihal:</strong>
                        <span>Laporan Keuangan Bulanan</span>
                    </div>
                    <div class="memo-field">
                        <strong>Lampiran:</strong>
                        <span>-</span>
                    </div>
                </div>
                <div class="memo-content">
                    <h4>Isi Memo:</h4>
                    <p>Dimohon untuk segera menyiapkan laporan keuangan bulanan untuk periode Juni 2025 dan diserahkan selambat-lambatnya tanggal 10 Juli 2025...</p>
                </div>
                <div class="memo-signature">
                    <strong>Manajer Keuangan</strong><br>
                    <em>Sari Dewi</em>
                </div>
                <div class="memo-actions">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="#" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="#" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CREATE TAB -->
    <div id="create" class="tab-content">
        <div class="memo-form">
            <h2 style="margin-bottom: 30px; color: #333; text-align: center;">
                <i class="fas fa-plus-circle"></i> Buat Memo Baru
            </h2>

            <form>
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
                        <input type="text" id="kepada" name="kepada" placeholder="Nama/Divisi penerima memo" required>
                    </div>
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="text" id="dari" name="dari" placeholder="Nama/Divisi pengirim memo" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <input type="text" id="perihal" name="perihal" placeholder="Subjek atau topik memo" required>
                    </div>
                    <div class="form-group">
                        <label for="lampiran">Lampiran</label>
                        <input type="text" id="lampiran" name="lampiran" placeholder="Jumlah lampiran (contoh: 2 berkas)">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="isi">Isi Memo</label>
                    <textarea id="isi" name="isi" placeholder="Tulis isi memo di sini..." rows="8" required></textarea>
                </div>

                <div class="form-group full-width">
                    <label>Tanda Tangan</label>
                    <div class="signature-area" onclick="document.getElementById('signature').click()">
                        <i class="fas fa-signature"></i>
                        <p>Klik untuk menambahkan tanda tangan digital</p>
                        <input type="file" id="signature" name="signature" accept="image/*" style="display: none;">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Memo
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-file-pdf"></i> Simpan sebagai PDF
                    </button>
                    <button type="reset" class="btn btn-danger">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.nav-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

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

// Auto-fill current date
document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

// Simple search functionality
document.querySelector('.search-box input').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const memoCards = document.querySelectorAll('.memo-card');
    
    memoCards.forEach(card => {
        const cardText = card.textContent.toLowerCase();
        if (cardText.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

@endsection