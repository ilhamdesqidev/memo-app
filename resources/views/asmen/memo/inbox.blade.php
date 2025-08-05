@extends('layouts.asisten_manager')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Memo Masuk</h1>
        
        <!-- Status Filter -->
        <div class="flex space-x-2">
            @foreach($statuses as $key => $label)
                <a href="{{ route('asmen.memo.inbox', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-lg {{ $currentStatus == $key ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                   {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengirim
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Perihal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($memos as $index => $memo)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $memos->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">
                                        {{ substr($memo->dibuatOleh->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $memo->dibuatOleh->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $memo->dari }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $memo->perihal }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $memo->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($memo->status == 'diajukan') bg-yellow-100 text-yellow-800
                                @elseif($memo->status == 'disetujui') bg-green-100 text-green-800
                                @elseif($memo->status == 'ditolak') bg-red-100 text-red-800
                                @elseif($memo->status == 'revisi') bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($memo->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('asmen.memo.show', $memo->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                            
                            @if($memo->status == 'diajukan')
                                <a href="{{ route('asmen.memo.show', $memo->id) }}" 
                                   class="text-green-600 hover:text-green-900 mr-3">Proses</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $memos->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $memos->lastItem() }}</span>
                        dari <span class="font-medium">{{ $memos->total() }}</span> hasil
                    </p>
                </div>
                <div>
                    {{ $memos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection