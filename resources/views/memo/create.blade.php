@extends('layouts.divisi')

@section('content')
<div class="container mt-4">
    <h2>Buat Memo Baru</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('marketing.memo.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor Memo</label>
            <input type="text" name="nomor" id="nomor" class="form-control" required value="{{ old('nomor') }}">
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{ old('tanggal') }}">
        </div>

        <div class="mb-3">
            <label for="kepada" class="form-label">Kepada</label>
            <input type="text" name="kepada" id="kepada" class="form-control" required value="{{ old('kepada') }}">
        </div>

        <div class="mb-3">
            <label for="dari" class="form-label">Dari</label>
            <input type="text" name="dari" id="dari" class="form-control" readonly value="{{ $divisi }}">
        </div>

        <div class="mb-3">
            <label for="perihal" class="form-label">Perihal</label>
            <input type="text" name="perihal" id="perihal" class="form-control" required value="{{ old('perihal') }}">
        </div>

        <div class="mb-3">
            <label for="divisi_tujuan" class="form-label">Divisi Tujuan</label>
            <select name="divisi_tujuan" id="divisi_tujuan" class="form-control" required>
                <option value="">-- Pilih Divisi --</option>
                <option value="Manager">Manager</option>
                <option value="Administrasi dan Keuangan">Administrasi dan Keuangan</option>
                <option value="Pengembangan Bisnis">Pengembangan Bisnis</option>
                <option value="Operasional Wilayah I">Operasional Wilayah I</option>
                <option value="Operasional Wilayah II">Operasional Wilayah II</option>
                <option value="Umum dan Legal">Umum dan Legal</option>
                <option value="Infrastruktur dan Sipil">Infrastruktur dan Sipil</option>
                <option value="Food Beverage">Food Beverage</option>
                <option value="Marketing dan Sales">Marketing dan Sales</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
            <input type="file" name="lampiran" id="lampiran" class="form-control">
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi Memo</label>
            <textarea name="isi" id="isi" rows="6" class="form-control" required>{{ old('isi') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Memo</button>
    </form>
</div>
@endsection
