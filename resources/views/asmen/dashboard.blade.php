@extends('layouts.asisten_manager') {{-- layout khusus asisten manager --}}

@section('title', 'Dashboard Asisten Manager')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Selamat datang, {{ auth()->user()->jabatan }}</h1>

    <p class="mb-4 text-gray-600">
        Divisi: <strong>{{ auth()->user()->divisi->nama ?? '-' }}</strong>
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold mb-2">Info Memo</h2>
            <ul class="list-disc ml-6 text-sm text-gray-700">
                <li>Total memo: 12</li>
                <li>Menunggu persetujuan: 3</li>
            </ul>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold mb-2">Tindakan Cepat</h2>
            <a href="#" class="text-blue-600 hover:underline">Lihat memo masuk</a>
        </div>
    </div>
</div>
@endsection
