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
</div>
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
    <a href="{{ route($routePrefix . '.memo.show', $memo->id) }}" class="text-blue-600 hover:underline">Detail</a>
    <button onclick="openApprovalModal({{ $memo->id }})" class="text-green-600 hover:underline ml-2">Setujui</button>
    <button onclick="openRejectModal({{ $memo->id }})" class="text-red-600 hover:underline ml-2">Tolak</button>
    <button onclick="openRevisiModal({{ $memo->id }})" class="text-yellow-600 hover:underline ml-2">Revisi</button>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $memos->links() }}
    </div>

    <!-- Modal Setujui -->
<div id="approveModal" class="fixed z-50 hidden inset-0 bg-black bg-opacity-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">Setujui Memo</h2>
        <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
            @csrf
            <input type="hidden" name="memo_id" id="approveMemoId">
            <label class="block mb-2">Lanjutkan ke Divisi:</label>
            <select name="next_divisi" class="w-full border p-2 mb-4">
                <option value="">-- Pilih Divisi Tujuan --</option>
                @foreach($divisiTujuan as $div)
                    <option value="{{ $div->nama }}">{{ $div->nama }}</option>
                @endforeach
            </select>
            <button name="action" value="setujui" class="bg-green-600 text-white px-4 py-2 rounded">Setujui</button>
            <button type="button" onclick="closeModals()" class="ml-2 text-gray-600">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="fixed z-50 hidden inset-0 bg-black bg-opacity-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">Tolak Memo</h2>
        <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
            @csrf
            <input type="hidden" name="memo_id" id="rejectMemoId">
            <textarea name="alasan" class="w-full border p-2 mb-4" placeholder="Alasan penolakan..."></textarea>
            <button name="action" value="tolak" class="bg-red-600 text-white px-4 py-2 rounded">Tolak</button>
            <button type="button" onclick="closeModals()" class="ml-2 text-gray-600">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Revisi -->
<div id="revisiModal" class="fixed z-50 hidden inset-0 bg-black bg-opacity-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">Revisi Memo</h2>
        <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
            @csrf
            <input type="hidden" name="memo_id" id="revisiMemoId">
            <textarea name="catatan_revisi" class="w-full border p-2 mb-4" placeholder="Catatan revisi..."></textarea>
            <button name="action" value="revisi" class="bg-yellow-500 text-white px-4 py-2 rounded">Kirim Revisi</button>
            <button type="button" onclick="closeModals()" class="ml-2 text-gray-600">Batal</button>
        </form>
    </div>
</div>


@endif
<script>
    function openApprovalModal(id) {
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveMemoId').value = id;
    }

    function openRejectModal(id) {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectMemoId').value = id;
    }

    function openRevisiModal(id) {
        document.getElementById('revisiModal').classList.remove('hidden');
        document.getElementById('revisiMemoId').value = id;
    }

    function closeModals() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('revisiModal').classList.add('hidden');
    }
</script>

@endsection