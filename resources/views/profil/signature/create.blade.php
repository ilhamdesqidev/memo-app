@extends(
    auth()->user()->role === 'manager' ? 'main' : 
    (auth()->user()->role === 'asisten_manager' ? 'layouts.asisten_manager' : 'layouts.divisi')
)

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Create Digital Signature</h1>
            <p class="text-gray-600">Create your personalized digital signature</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h2 class="text-xl font-medium text-white">Signature Creation</h2>
            </div>

            <div class="p-8">
                <!-- Navigation Tabs -->
                <div class="mb-8">
                    <nav class="flex space-x-1 bg-gray-100 p-1 rounded-xl">
                        <button id="draw-tab" class="flex-1 py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Draw Signature
                        </button>
                        <button id="upload-tab" class="flex-1 py-2.5 px-4 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload Image
                        </button>
                    </nav>
                </div>

                <!-- Draw Signature Panel -->
                <div id="draw-panel" class="signature-panel">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Draw your signature below:</label>
                        
                        <!-- Canvas Container -->
                        <div class="border-2 border-gray-200 rounded-xl bg-white overflow-hidden">
                            <canvas id="signature-canvas" width="600" height="250" class="w-full cursor-crosshair block"></canvas>
                        </div>
                        
                        <!-- Canvas Controls -->
                        <div class="mt-4 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex space-x-2">
                                <button id="clear-signature" class="inline-flex items-center px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Clear
                                </button>
                                <button id="undo-signature" class="inline-flex items-center px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    Undo
                                </button>
                            </div>
                            <div class="flex items-center space-x-3">
                                <label class="text-sm font-medium text-gray-700">Pen Size:</label>
                                <input type="range" id="pen-size" min="1" max="5" value="2" class="w-24 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <span id="pen-size-value" class="text-sm text-gray-600 w-4">2</span>
                            </div>
                        </div>
                    </div>
                    
                    <form id="signature-form" action="{{ route($routes['signature']['save']) }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" id="signature-data" name="signature_data">
                        <div class="flex flex-wrap gap-3">
                            <button type="submit" id="save-signature" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Signature
                            </button>
                            <a href="{{ route($routes['signature']['index']) }}" class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Upload Signature Panel -->
                <div id="upload-panel" class="signature-panel hidden">
                    <form action="{{ route($routes['signature']['upload']) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Upload signature image
                            </label>
                            <div class="relative">
                                <input type="file" 
                                    name="signature" 
                                    accept="image/png,image/jpg,image/jpeg" 
                                    class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors duration-200"
                                    required>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload Signature
                            </button>
                            <a href="{{ route($routes['signature']['index']) }}" class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tips Card -->
        <div class="mt-8 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tips for better signature
            </h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <span>Sign naturally as you would on paper</span>
                </div>
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <span>Use a consistent writing speed</span>
                </div>
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <span>Keep your signature readable</span>
                </div>
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <span>Upload high-quality images for best results</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const drawTab = document.getElementById('draw-tab');
    const uploadTab = document.getElementById('upload-tab');
    const drawPanel = document.getElementById('draw-panel');
    const uploadPanel = document.getElementById('upload-panel');

    drawTab.addEventListener('click', function() {
        // Active draw tab
        drawTab.classList.add('text-white', 'bg-blue-600');
        drawTab.classList.remove('text-gray-600');
        // Inactive upload tab
        uploadTab.classList.add('text-gray-600');
        uploadTab.classList.remove('text-white', 'bg-blue-600');
        // Show/hide panels
        drawPanel.classList.remove('hidden');
        uploadPanel.classList.add('hidden');
    });

    uploadTab.addEventListener('click', function() {
        // Active upload tab
        uploadTab.classList.add('text-white', 'bg-blue-600');
        uploadTab.classList.remove('text-gray-600');
        // Inactive draw tab
        drawTab.classList.add('text-gray-600');
        drawTab.classList.remove('text-white', 'bg-blue-600');
        // Show/hide panels
        uploadPanel.classList.remove('hidden');
        drawPanel.classList.add('hidden');
    });

    // Signature canvas
    const canvas = document.getElementById('signature-canvas');
    const ctx = canvas.getContext('2d');
    const clearButton = document.getElementById('clear-signature');
    const undoButton = document.getElementById('undo-signature');
    const penSizeSlider = document.getElementById('pen-size');
    const penSizeValue = document.getElementById('pen-size-value');
    const saveButton = document.getElementById('save-signature');
    const signatureForm = document.getElementById('signature-form');
    const signatureData = document.getElementById('signature-data');

    let isDrawing = false;
    let paths = [];
    let currentPath = [];

    // Update pen size display
    penSizeSlider.addEventListener('input', function() {
        penSizeValue.textContent = this.value;
    });

    // Set canvas size
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width * window.devicePixelRatio;
        canvas.height = rect.height * window.devicePixelRatio;
        ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        canvas.style.width = rect.width + 'px';
        canvas.style.height = rect.height + 'px';
        
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#000000';
    }

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Drawing functions
    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

    function startDrawing(e) {
        isDrawing = true;
        currentPath = [];
        const pos = getMousePos(e);
        
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        currentPath.push({x: pos.x, y: pos.y, type: 'start'});
    }

    function draw(e) {
        if (!isDrawing) return;
        
        const pos = getMousePos(e);
        ctx.lineWidth = penSizeSlider.value;
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        
        currentPath.push({x: pos.x, y: pos.y, type: 'draw'});
        enableSaveButton();
    }

    function stopDrawing() {
        if (!isDrawing) return;
        isDrawing = false;
        if (currentPath.length > 0) {
            paths.push([...currentPath]);
        }
        currentPath = [];
    }

    // Touch events for mobile
    function getTouchPos(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.touches[0].clientX - rect.left,
            y: e.touches[0].clientY - rect.top
        };
    }

    function touchStart(e) {
        e.preventDefault();
        const pos = getTouchPos(e);
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: pos.x + canvas.getBoundingClientRect().left,
            clientY: pos.y + canvas.getBoundingClientRect().top
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function touchMove(e) {
        e.preventDefault();
        const pos = getTouchPos(e);
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: pos.x + canvas.getBoundingClientRect().left,
            clientY: pos.y + canvas.getBoundingClientRect().top
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function touchEnd(e) {
        e.preventDefault();
        const mouseEvent = new MouseEvent('mouseup', {});
        canvas.dispatchEvent(mouseEvent);
    }

    // Event listeners
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Touch events
    canvas.addEventListener('touchstart', touchStart);
    canvas.addEventListener('touchmove', touchMove);
    canvas.addEventListener('touchend', touchEnd);

    // Clear canvas
    clearButton.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        paths = [];
        currentPath = [];
        disableSaveButton();
    });

    // Undo last stroke
    undoButton.addEventListener('click', function() {
        if (paths.length > 0) {
            paths.pop();
            redrawCanvas();
            if (paths.length === 0) {
                disableSaveButton();
            }
        }
    });

    // Redraw canvas
    function redrawCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        paths.forEach(path => {
            if (path.length > 0) {
                ctx.beginPath();
                ctx.moveTo(path[0].x, path[0].y);
                
                for (let i = 1; i < path.length; i++) {
                    if (path[i].type === 'draw') {
                        ctx.lineWidth = penSizeSlider.value;
                        ctx.lineTo(path[i].x, path[i].y);
                    }
                }
                ctx.stroke();
            }
        });
    }

    // Save signature
    signatureForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (paths.length === 0) {
            alert('Please draw your signature first.');
            return;
        }

        // Convert canvas to base64
        const dataURL = canvas.toDataURL('image/png');
        signatureData.value = dataURL;
        
        // Submit form
        this.submit();
    });

    function enableSaveButton() {
        saveButton.disabled = false;
        saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    function disableSaveButton() {
        saveButton.disabled = true;
        saveButton.classList.add('opacity-50', 'cursor-not-allowed');
    }
});
</script>
@endpush
@endsection