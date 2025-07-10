@extends('main')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('staff.memo.index') }}" class="text-gray-600 hover:text-gray-800 mr-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Detail Memo</h2>
            </div>
            <p class="text-gray-600">Lihat informasi lengkap tentang memo ini termasuk tanda tangan digital</p>
        </div>

        <!-- Memo Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-lg font-semibold text-gray-800">Memo</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                            {{ $memo->nomor }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700 border border-gray-200">
                            {{ \Carbon\Carbon::parse($memo->tanggal)->format('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6 space-y-6">
                <!-- Memo Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kepada -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-600 uppercase tracking-wide">Kepada</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-800">{{ $memo->kepada }}</p>
                    </div>

                    <!-- Dari -->
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-500">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="text-sm font-medium text-green-600 uppercase tracking-wide">Dari</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-800">{{ $memo->dari }}</p>
                    </div>
                </div>

                <!-- Perihal -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="text-sm font-medium text-purple-600 uppercase tracking-wide">Perihal</span>
                    </div>
                    <p class="text-lg font-semibold text-gray-800">{{ $memo->perihal }}</p>
                </div>

                <!-- Isi Memo -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-600 uppercase tracking-wide">Isi Memo</span>
                    </div>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $memo->isi }}</p>
                    </div>
                </div>

                <!-- Digital Signature -->
                @if($memo->signature)
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-sm font-medium text-indigo-600 uppercase tracking-wide">Tanda Tangan Digital</span>
                    </div>
                    <div class="flex justify-end">
                        <div class="text-center bg-white p-6 rounded-lg border border-gray-200 shadow-sm" style="max-width: 300px;">
                            @if(pathinfo($memo->signature, PATHINFO_EXTENSION) === 'pdf')
                                <embed src="{{ asset('storage/' . $memo->signature) }}" 
                                       type="application/pdf" 
                                       width="250" 
                                       height="150" 
                                       class="border rounded-lg mb-4 shadow-sm">
                            @else
                                <img src="{{ asset('storage/' . $memo->signature) }}" 
                                     alt="Tanda Tangan" 
                                     class="max-h-32 mx-auto border rounded-lg mb-4 shadow-sm">
                            @endif
                            <div class="pt-3 border-t border-gray-200">
                                <p class="font-semibold text-indigo-600">{{ $memo->dari }}</p>
                                <p class="text-sm text-gray-500 mt-1">Penandatangan</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-wrap justify-end gap-3">
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak
                    </button>
                    
                    <a href="{{ route('staff.memo.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    
                    <a href="{{ route('staff.memo.edit', $memo->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    
                    <form action="{{ route('staff.memo.destroy', $memo->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus memo ini?')"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth entrance animation
    const elements = document.querySelectorAll('.bg-gray-50, .bg-white');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = `all 0.5s ease ${index * 0.1}s`;
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 50);
    });
    
    // Enhanced print styles
    const printStyles = document.createElement('style');
    printStyles.textContent = `
        @media print {
            .p-6 { padding: 0 !important; }
            
            /* Hide navigation and buttons */
            .flex.items-center.mb-4,
            .px-6.py-4.bg-gray-50.border-t.border-gray-200 {
                display: none !important;
            }
            
            /* Clean up layout for print */
            .bg-white.rounded-lg.shadow-sm.border.border-gray-200 {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                border-radius: 0 !important;
            }
            
            /* Remove background colors for print */
            .bg-gray-50,
            .bg-gradient-to-r.from-blue-50.to-indigo-50 {
                background-color: transparent !important;
            }
            
            /* Ensure text is black */
            .text-gray-800,
            .text-gray-700,
            .text-gray-600 {
                color: #000 !important;
            }
            
            /* Signature styling for print */
            .bg-white.p-6.rounded-lg.border.border-gray-200.shadow-sm {
                background-color: transparent !important;
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }
            
            /* Optimize signature size for print */
            img, embed {
                max-height: 80px !important;
            }
            
            /* Page break control */
            .space-y-6 > div {
                page-break-inside: avoid;
            }
        }
    `;
    document.head.appendChild(printStyles);
    
    // Add hover effects for interactive elements
    const buttons = document.querySelectorAll('button, a');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection