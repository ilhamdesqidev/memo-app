@extends('layouts.divisi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Buat Memo Baru</h1>
            <p class="text-gray-600 mt-1">Buat memo untuk komunikasi antar divisi</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Section -->
        <form action="{{ route($routePrefix . '.memo.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Memo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Memo *</label>
                        <input type="text" name="nomor" value="{{ old('nomor') }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal *</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

<<<<<<< HEAD
                    <!-- Kepada -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Kepada *</label>
                        <input type="text" id="kepada_search" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Cari nama penerima..." autocomplete="off">
                        <input type="hidden" name="kepada" id="kepada">
                        <input type="hidden" name="kepada_id" id="kepada_id">
                        <div id="kepadaDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"></div>
                    </div>
=======
                        <!-- Kepada -->
                        <div class="space-y-2">
                            <label for="kepada" class="block text-sm font-semibold text-gray-700">
                                Kepada
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="kepada" 
                                        id="kepada" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 appearance-none bg-white" 
                                        required>
                                    <option value="" disabled selected>Pilih Penerima Memo</option>
                                    @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                                        <option value="{{ $user->id }}" 
                                            data-divisi="{{ $user->divisi->nama }}"
                                            {{ old('kepada') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
>>>>>>> 19401867fae808ac6fd82178ac43488bfc36d414

                    <!-- Dari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari</label>
                        <input type="text" value="{{ auth()->user()->divisi->nama }}" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <input type="hidden" name="dari" value="{{ auth()->user()->divisi->nama }}">
                    </div>

                    <!-- Perihal -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Perihal *</label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Divisi Tujuan -->
<<<<<<< HEAD
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Divisi Tujuan *</label>
                        <input type="text" name="divisi_tujuan" id="divisi_tujuan" readonly
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
=======
                    <div class="mt-6 space-y-2">
                        <label for="divisi_tujuan" class="block text-sm font-semibold text-gray-700">
                            Divisi Tujuan
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="divisi_tujuan" 
                                   id="divisi_tujuan" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 cursor-not-allowed" 
                                   readonly
                                   value="{{ old('divisi_tujuan') }}"
                                   placeholder="Divisi akan terisi otomatis">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
>>>>>>> 19401867fae808ac6fd82178ac43488bfc36d414
                    </div>

                    <!-- Isi Memo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Isi Memo *</label>
                        <textarea name="isi" rows="6"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>{{ old('isi') }}</textarea>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Memo
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('kepada_search');
    const kepadaInput = document.getElementById('kepada');
    const kepadaIdInput = document.getElementById('kepada_id');
    const divisiInput = document.getElementById('divisi_tujuan');
    const dropdown = document.getElementById('kepadaDropdown');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            dropdown.classList.add('hidden');
            return;
        }

        fetch(`/api/search-users?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                dropdown.innerHTML = '';
                
                if (users.length === 0) {
                    dropdown.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ditemukan</div>';
                } else {
                    users.forEach(user => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        div.innerHTML = `
                            <div class="font-medium">${user.name}</div>
                            <div class="text-xs text-gray-500">${user.divisi_nama}</div>
                        `;
                        div.addEventListener('click', () => {
                            searchInput.value = user.name;
                            kepadaInput.value = user.name;
                            kepadaIdInput.value = user.id;
                            divisiInput.value = user.divisi_nama;
                            dropdown.classList.add('hidden');
                        });
                        dropdown.appendChild(div);
                    });
                }
                dropdown.classList.remove('hidden');
            });
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>
=======
                    <!-- Lampiran -->
                    <div class="mt-4 space-y-2 pb-4">
                        <label for="lampiran" class="block text-sm font-semibold text-gray-700">
                            Lampiran (Jumlah)
                            <span class="text-gray-500 text-xs font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="flex rounded-lg shadow-sm">
                                <button type="button" 
                                        class="decrement-btn px-4 py-3 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-gray-100 transition duration-200"
                                        onclick="decrementValue()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       name="lampiran" 
                                       id="lampiran" 
                                       min="0"
                                       max="10"
                                       value="{{ old('lampiran', 0) }}"
                                       class="w-20 px-4 py-3 text-center border-t border-b border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                <button type="button" 
                                        class="increment-btn px-4 py-3 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-r-lg hover:bg-gray-200 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-gray-100 transition duration-200"
                                        onclick="incrementValue()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Masukkan jumlah lampiran (0-10)
                        </p>
                    </div>

                    <script>
                        function incrementValue() {
                            const input = document.getElementById('lampiran');
                            let value = parseInt(input.value);
                            if (value < 10) {
                                input.value = value + 1;
                            }
                        }

                        function decrementValue() {
                            const input = document.getElementById('lampiran');
                            let value = parseInt(input.value);
                            if (value > 0) {
                                input.value = value - 1;
                            }
                        }

                        // Auto-fill divisi tujuan based on selected user
                        document.getElementById('kepada').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const divisiTujuan = selectedOption.getAttribute('data-divisi');
                            document.getElementById('divisi_tujuan').value = divisiTujuan;
                        });

                        // Initialize divisi tujuan if there's old input
                        window.addEventListener('load', function() {
                            const kepadaSelect = document.getElementById('kepada');
                            if (kepadaSelect.value) {
                                const selectedOption = kepadaSelect.options[kepadaSelect.selectedIndex];
                                const divisiTujuan = selectedOption.getAttribute('data-divisi');
                                document.getElementById('divisi_tujuan').value = divisiTujuan;
                            }
                        });
                    </script>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <a href="{{ route($routePrefix . '.memo.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Memo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
>>>>>>> 19401867fae808ac6fd82178ac43488bfc36d414
@endsection