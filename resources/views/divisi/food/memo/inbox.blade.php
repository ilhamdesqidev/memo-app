@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Memo Masuk - Food Beverage</h1>
    
    @include('divisi.shared.memo_table', ['memos' => $memos])
</div>
@endsection