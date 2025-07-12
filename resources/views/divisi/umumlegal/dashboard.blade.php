<<<<<<< HEAD
@extends('layouts.divisi')
=======
@extends('main2')
>>>>>>> 61812e36742b93c23999ba57e6fedff286b2e057

@section('content')
    <div class="container">
        <h1>Dashboard {{ ucfirst($divisi ?? 'Divisi') }}</h1>
        <p>Selamat datang di halaman dashboard divisi.</p>
    </div>
@endsection
