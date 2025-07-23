@extends('layouts.divisi')
@section('content')



@if ($memos->isEmpty())
    <div class="bg-gray-100 p-4 rounded-lg text-center">
        <p class="text-gray-600">Tidak ada memo.</p>
    </div>
@else
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari/Kepada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($memos as $memo)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->nomor }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($memo->dari === $currentDivisi)
                                <span class="text-blue-600">Kepada: {{ $memo->divisi_tujuan }}</span>
                            @else
                                <span class="text-green-600">Dari: {{ $memo->dari }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->perihal }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->tanggal->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route($routePrefix . '.memo.show', $memo->id) }}" 
                               class="text-blue-600 hover:text-blue-800 hover:underline">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $memos->links() }}
    </div>
@endif

@endsection