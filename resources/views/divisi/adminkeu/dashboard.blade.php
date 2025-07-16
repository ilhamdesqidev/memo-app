@extends('layouts.divisi')

@section('content')
    <div class="container">
        <h1>Dashboard {{ ucfirst($divisi ?? 'Divisi') }}</h1>
        <p>Selamat datang di halaman dashboard Admin Keuangan.</p>
    </div>
@endsection
