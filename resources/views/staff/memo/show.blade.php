@extends('main')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('staff.memo.index') }}" class="text-gray-600 hover:text-gray-800 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Detail Memo</h2>
            </div>
        </div>

        <!-- Memo Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <!-- Memo Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-600">No. {{ $memo->nomor }}</span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($memo->tanggal)->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Memo Content -->
            <div class="p-6 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kepada</p>
                        <p class="text-lg">{{ $memo->kepada }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dari</p>
                        <p class="text-lg">{{ $memo->dari }}</p>
                    </div>
                </div>

                <!-- Perihal -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Perihal</p>
                    <p class="text-lg font-semibold">{{ $memo->perihal }}</p>
                </div>

                <!-- Isi Memo -->
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm font-medium text-gray-500 mb-2">Isi Memo</p>
                    <div class="prose max-w-none">
                        {!! nl2br(e($memo->isi)) !!}
                    </div>
                </div>

                <!-- Signature Section -->
                @if($memo->signature)
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-medium mb-2">Tanda Tangan</h3>
                    
                    @if(file_exists(storage_path('app/public/'.$memo->signature)))
                        @if(Str::endsWith($memo->signature, '.pdf'))
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <embed src="{{ url('storage/'.$memo->signature) }}" 
                                type="application/pdf"
                                width="100%"
                                height="300px">
                            <p class="text-center mt-2 text-sm text-gray-500">
                                {{ $memo->dari }}
                            </p>
                        </div>
                        @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <img src="{{ url('storage/'.$memo->signature) }}" 
                                alt="Tanda Tangan"
                                class="max-h-40 mx-auto mb-2">
                            <p class="text-sm text-gray-500">
                                {{ $memo->dari }}
                            </p>
                        </div>
                        @endif
                    @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    File tanda tangan tidak ditemukan di: 
                                    <code class="bg-yellow-100 px-1">storage/app/public/{{ $memo->signature }}</code>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                <a href="{{ route('staff.memo.edit', $memo->id) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('staff.memo.destroy', $memo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus memo ini?')">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
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