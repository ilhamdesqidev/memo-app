@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Detail Memo</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="font-semibold">Nomor:</p>
                <p>{{ $memo->nomor }}</p>
            </div>
            <div>
                <p class="font-semibold">Tanggal:</p>
                <p>{{ $memo->tanggal->format('d F Y') }}</p>
            </div>
            <div>
                <p class="font-semibold">Dari:</p>
                <p>{{ $memo->dari }}</p>
            </div>
            <div>
                <p class="font-semibold">Kepada:</p>
                <p>{{ $memo->divisi_tujuan }}</p>
            </div>
        </div>
        
        <div class="mt-6">
            <p class="font-semibold">Perihal:</p>
            <p class="text-lg">{{ $memo->perihal }}</p>
        </div>
        
        <div class="mt-6">
            <p class="font-semibold">Isi Memo:</p>
            <div class="prose max-w-none">
                {!! nl2br(e($memo->isi)) !!}
            </div>
        </div>
    </div>
</div>
@endsection