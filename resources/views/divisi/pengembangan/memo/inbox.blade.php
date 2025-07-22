@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Memo Masuk - Operasional Wilayah II</h1>

    @if ($memos->isEmpty())
        <div class="bg-gray-100 p-4 rounded-lg text-center">
            <p class="text-gray-600">Tidak ada memo masuk.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($memos as $memo)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->dari }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->perihal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('pengembangan.memo.show', $memo->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 hover:underline">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if ($memos->hasPages())
            <div class="mt-4">
                {{ $memos->links() }}
            </div>
        @endif
    @endif
</div>
@endsection