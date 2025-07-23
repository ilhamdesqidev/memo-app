@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Memo Masuk - {{ $currentDivisi }}</h1>
    
    <div class="mb-4">
        <a href="{{ route($routePrefix . '.memo.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Memo Keluar
        </a>
    </div>

    @include('divisi.shared.memo_table')
</div>
@endsection