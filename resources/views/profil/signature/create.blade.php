@extends('main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Create Digital Signature</h2>
        </div>
        
        <div class="p-6">
            <!-- Navigation Tabs -->
            <div class="mb-4">
                <nav class="flex space-x-4 border-b border-gray-200">
                    <button id="draw-tab" class="py-2 px-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                        Draw Signature
                    </button>
                    <button id="upload-tab" class="py-2 px-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Upload Image
                    </button>
                </nav>
            </div>

            <!-- Draw Signature Panel -->
            <div id="draw-panel" class="signature-panel">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Draw your signature below:</p>
                    <div class="border-2 border-gray-300 rounded-lg bg-white">
                        <canvas id="signature-canvas" width="400" height="200" class="w-full cursor-crosshair"></canvas>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button id="clear-signature" class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Clear
                            </button>
                            <button id="undo-signature" class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Undo
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600">Pen Size:</label>
                            <input type="range" id="pen-size" min="1" max="5" value="2" class="w-20">
                        </div>
                    </div>
                </div>
                
                <form id="signature-form" action="{{ route('profil.signature.save') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="signature-data" name="signature_data">
                    <div class="flex space-x-2">
                        <button type="submit" id="save-signature" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition" disabled>
                            Save Signature
                        </button>
                        <a href="{{ route('profil.signature.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Upload Signature Panel -->
            <div id="upload-panel" class="signature-panel hidden">
                <form action="{{ route('profil.signature.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Signature Image (PNG, JPG, JPEG - Max 2MB)
                        </label>
                        <input type="file" 
                               name="signature" 
                               accept="image/png,image/jpg,image/jpeg" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                               required>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Upload Signature
                        </button>
                        <a href="{{ route('profil.signature.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            @if($errors->any())
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Script untuk canvas signature (sama seperti sebelumnya) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const drawTab = document.getElementById('draw-tab');
    const uploadTab = document.getElementById('upload-tab');
    const drawPanel = document.getElementById('draw-panel');
    const uploadPanel = document.getElementById('upload-panel');

    drawTab.addEventListener('click', function() {
        drawTab.classList.add('text-indigo-600', 'border-indigo-600');
        drawTab.classList.remove('text-gray-500');
        uploadTab.classList.add('text-gray-500');
        uploadTab.classList.remove('text-indigo-600', 'border-indigo-600');
        drawPanel.classList.remove('hidden');
        uploadPanel.classList.add('hidden');
    });

    uploadTab.addEventListener('click', function() {
        uploadTab.classList.add('text-indigo-600', 'border-indigo-600');
        uploadTab.classList.remove('text-gray-500');
        drawTab.classList.add('text-gray-500');
        drawTab.classList.remove('text-indigo-600', 'border-indigo-600');
        uploadPanel.classList.remove('hidden');
        drawPanel.classList.add('hidden');
    });

    // Signature canvas
    const canvas = document.getElementById('signature-canvas');
    const ctx = canvas.getContext('2d');
    const clearButton = document.getElementById('clear-signature');
    const undoButton = document.getElementById('undo-signature');
    const penSizeSlider = document.getElementById('pen-size');
    const saveButton = document.getElementById('save-signature');
    const signatureForm = document.getElementById('signature-form');
    const signatureData = document.getElementById('signature-data');

    let isDrawing = false;
    let paths = [];
    let currentPath = [];

    // Set canvas size
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#000000';
    }

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Drawing functions
    function startDrawing(e) {
        isDrawing = true;
        currentPath = [];
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ctx.beginPath();
        ctx.moveTo(x, y);
        currentPath.push({x, y, type: 'start'});
    }

    function draw(e) {
        if (!isDrawing) return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ctx.lineWidth = penSizeSlider.value;
        ctx.lineTo(x, y);
        ctx.stroke();
        
        currentPath.push({x, y, type: 'draw'});
        enableSaveButton();
    }

    function stopDrawing() {
        if (!isDrawing) return;
        isDrawing = false;
        paths.push([...currentPath]);
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
        const touch = getTouchPos(e);
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.x + canvas.getBoundingClientRect().left,
            clientY: touch.y + canvas.getBoundingClientRect().top
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function touchMove(e) {
        e.preventDefault();
        const touch = getTouchPos(e);
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.x + canvas.getBoundingClientRect().left,
            clientY: touch.y + canvas.getBoundingClientRect().top
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
@endsection