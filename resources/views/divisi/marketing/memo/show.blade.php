@extends('layouts.divisi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Detail Memo</h1>

    <div class="bg-white shadow rounded p-4">
        <div class="mb-4">
            <label class="font-semibold">Nomor Memo:</label>
            <p>{{ $memo->nomor }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Tanggal:</label>
            <p>{{ \Carbon\Carbon::parse($memo->tanggal)->format('d-m-Y') }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Kepada:</label>
            <p>{{ $memo->kepada }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Dari:</label>
            <p>{{ $memo->dari }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Divisi Tujuan:</label>
            <p>{{ $memo->divisi_tujuan }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Perihal:</label>
            <p>{{ $memo->perihal }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Isi Memo:</label>
            <div class="border p-2 rounded bg-gray-50">{!! nl2br(e($memo->isi)) !!}</div>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Status:</label>
            <p>{{ $memo->status }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Lampiran:</label>
            @if ($memo->lampiran)
                <p>
                    <a href="{{ asset('storage/' . $memo->lampiran) }}" target="_blank" class="text-blue-600 hover:underline">
                        Lihat Lampiran
                    </a>
                </p>
            @else
                <p>Tidak ada lampiran.</p>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('marketing.memo.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded">
                Kembali ke Daftar Memo
            </a>
        </div>
    </div>
</div>
@endsection
