@extends('main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <h1 class="text-xl font-semibold text-white">My Profile</h1>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <!-- Profile Info -->
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                        @if(Auth::user()->divisi)
                            <span class="inline-block mt-2 px-3 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full">
                                {{ Auth::user()->divisi }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Personal Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Personal Information</h3>
                        <div class="space-y-2 text-sm">
                            <div><span class="text-gray-500">Name:</span> {{ Auth::user()->name }}</div>
                            <div><span class="text-gray-500">Username:</span> {{ Auth::user()->username }}</div>
                            <div><span class="text-gray-500">Jabatan:</span> {{ Auth::user()->jabatan }}</div>
                        </div>
                    </div>

                    <!-- Signature -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Digital Signature</h3>
                        
                        @if(Auth::user()->signature)
                            <div class="w-full h-32 border border-gray-300 rounded bg-white flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/' . Auth::user()->signature) }}" 
                                     alt="Signature" 
                                     class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-full h-32 border border-dashed border-gray-300 rounded bg-white flex items-center justify-center">
                                <span class="text-gray-400 text-base">No signature</span>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('profil.edit') }}" 
                               class="block w-full px-4 py-2 bg-indigo-600 text-white text-center rounded hover:bg-indigo-700 transition">
                                Edit Profile
                            </a>
                            <a href="{{ route('profil.signature.index') }}" 
                               class="block w-full px-4 py-2 bg-green-600 text-white text-center rounded hover:bg-green-700 transition">
                                Manage Signature
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const drawTab = document.getElementById('draw-tab');
    const uploadTab = document.getElementById('upload-tab');
    const drawPanel = document.getElementById('draw-panel');
    const uploadPanel = document.getElementById('upload-panel');

    if (drawTab && uploadTab) {
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
    }

    // Signature canvas
    const canvas = document.getElementById('signature-canvas');
    if (!canvas) return;

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
        
        ctx.lineWidth = penSizeSlider ? penSizeSlider.value : 2;
        ctx.lineTo(x, y);
        ctx.stroke();
        
        currentPath.push({x, y, type: 'draw'});
        if (saveButton) enableSaveButton();
    }

    function stopDrawing() {
        if (!isDrawing) return;
        isDrawing = false;
        paths.push([...currentPath]);
        currentPath = [];
    }

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

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    canvas.addEventListener('touchstart', touchStart);
    canvas.addEventListener('touchmove', touchMove);
    canvas.addEventListener('touchend', touchEnd);

    if (clearButton) {
        clearButton.addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            paths = [];
            currentPath = [];
            if (saveButton) disableSaveButton();
        });
    }

    if (undoButton) {
        undoButton.addEventListener('click', function() {
            if (paths.length > 0) {
                paths.pop();
                redrawCanvas();
                if (paths.length === 0 && saveButton) {
                    disableSaveButton();
                }
            }
        });
    }

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

    if (signatureForm) {
        signatureForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (paths.length === 0) {
                alert('Please draw your signature first.');
                return;
            }

            const dataURL = canvas.toDataURL('image/png');
            if (signatureData) {
                signatureData.value = dataURL;
            }
            
            this.submit();
        });
    }

    function enableSaveButton() {
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function disableSaveButton() {
        if (saveButton) {
            saveButton.disabled = true;
            saveButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
});
</script>
@endsection