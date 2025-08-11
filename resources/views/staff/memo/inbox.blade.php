@extends('layouts.divisi')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    
    <div class="mb-3">
        <a href="{{ route('staff.memo.index') }}" class="btn btn-secondary">Memo Keluar</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Memo</th>
                        <th>Tanggal</th>
                        <th>Dari</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memos as $memo)
                    <tr>
                        <td>{{ $memo->nomor }}</td>
                        <td>{{ $memo->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $memo->dari }}</td>
                        <td>{{ $memo->perihal }}</td>
                        <td>
                            <span class="badge bg-{{ $memo->status === 'disetujui' ? 'success' : ($memo->status === 'ditolak' ? 'danger' : 'warning') }}">
                                {{ ucfirst($memo->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.memo.show', $memo->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $memos->links() }}
        </div>
    </div>
</div>
@endsection