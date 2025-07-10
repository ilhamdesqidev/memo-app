@extends('main')
@section('content')

<style>
    /* Same styles as create.blade.php */
</style>

<div class="memo-container">
    <div class="header">
        <h1><i class="fas fa-edit"></i> Edit Memo</h1>
        <p>Perbarui informasi memo berikut</p>
    </div>

    <div class="memo-form">
        <form method="POST" action="{{ route('staff.memo.update', $memo->id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nomor">Nomor Memo</label>
                    <input type="text" id="nomor" name="nomor" value="{{ $memo->nomor }}" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $memo->tanggal->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kepada">Kepada</label>
                    <input type="text" id="kepada" name="kepada" value="{{ $memo->kepada }}" required>
                </div>
                <div class="form-group">
                    <label for="dari">Dari</label>
                    <input type="text" id="dari" name="dari" value="{{ $memo->dari }}" required>
                </div>
            </div>

            <!-- Include all other fields with current values -->

            <div class="form-actions">
                <a href="{{ route('staff.memo.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill current date
document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

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