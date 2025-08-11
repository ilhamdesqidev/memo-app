@extends(
    auth()->user()->role === 'manager' ? 'main' : 
    (auth()->user()->role === 'asisten_manager' ? 'layouts.asisten_manager' : 
    (auth()->user()->role === 'asisten' ? 'layouts.asisten' : 'layouts.divisi'))
)


@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profil</h1>
            <p class="text-gray-600">Manage your personal information and account settings</p>
        </div>

        <!-- Main Profil Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-6 ring-4 ring-indigo-300">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                            <p class="text-indigo-100 mt-1">{{ Auth::user()->jabatan }}</p>
                            @if(Auth::user()->divisi)
                                @php
                                    $divisiConfig = [
                                        'Pengembangan Bisnis' => ['color' => 'bg-blue-400', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                                        'Operasional Wilayah I' => ['color' => 'bg-green-400', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                                        'Operasional Wilayah II' => ['color' => 'bg-teal-400', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                                        'Umum dan Legal' => ['color' => 'bg-purple-400', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'Administrasi dan Keuangan' => ['color' => 'bg-yellow-500', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'Infrastruktur dan Sipil' => ['color' => 'bg-orange-400', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                        'Food Beverage' => ['color' => 'bg-red-400', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'Marketing dan Sales' => ['color' => 'bg-pink-400', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']
                                    ];
                                    
                                    $currentDivisi = Auth::user()->divisi->nama;
                                    $config = $divisiConfig[$currentDivisi] ?? ['color' => 'bg-gray-400', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'];
                                @endphp

                                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full font-medium {{ $config['color'] }} text-white">
                                    <svg class="w-3 h-3 my-2 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                    </svg>
                                    {{ $currentDivisi }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-indigo-100 text-sm">Member since</div>
                        <div class="text-white font-semibold">{{ Auth::user()->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-8">
                <!-- Profil Information Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Full Name</div>
                                    <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Username</div>
                                    <div class="font-medium text-gray-800">{{ Auth::user()->username }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Position</div>
                                    <div class="font-medium text-gray-800">{{ Auth::user()->jabatan }}</div>
                                </div>
                            </div>
                            @if(Auth::user()->divisi)
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Division</div>
                                    <div class="font-medium text-gray-800">{{ Auth::user()->divisi->nama }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Digital Signature -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Digital Signature</h3>
                        </div>
                        
                        <div class="space-y-4">
                            @if(Auth::user()->signature)
                                <div class="relative">
                                    <div class="w-full h-40 border-2 border-dashed border-indigo-200 rounded-lg bg-white flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . Auth::user()->signature) }}" 
                                             alt="Digital Signature" 
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Active
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-40 border-2 border-dashed border-gray-300 rounded-lg bg-white flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="text-gray-500 text-sm">No signature uploaded</span>
                                    <span class="text-gray-400 text-xs mt-1">Click "Manage Signature" to add one</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                        </div>
                        <div class="space-y-3">
                            <a href="{{route('profil.edit') }}" 
                            class="flex items-center w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 group">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="{{ route('profil.signature.index') }}" 
                            class="flex items-center w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 group">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Manage Signature
                            </a>
                        </div>
                

                        <!-- Account Stats -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-500 mb-2">Account Statistics</div>
                            <div class="flex justify-between">
                                <div class="text-center">
                                    <div id="activeTime" class="text-lg font-medium text-indigo-600">
                                        @php
                                            $created = Auth::user()->created_at;
                                            $now = now();
                                            $diff = $created->diff($now);
                                        @endphp
                                        {{ $diff->format('%a days %h hours %i minutes %s seconds') }}
                                    </div>
                                    <div class="text-xs text-gray-500">Active Time</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-medium text-green-600">
                                        {{ Auth::user()->signature ? '1' : '0' }}
                                    </div>
                                    <div class="text-xs text-gray-500">Signatures</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Session Management</h3>
                            <p class="text-sm text-gray-600">Securely end your current session</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 group">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Active time counter
    const createdAt = new Date("{{ Auth::user()->created_at->format('Y-m-d H:i:s') }}");
    const activeTimeElement = document.getElementById('activeTime');
    
    function updateActiveTime() {
        const now = new Date();
        const diff = Math.floor((now - createdAt) / 1000); // difference in seconds
        
        // Calculate days, hours, minutes, seconds
        const days = Math.floor(diff / 86400);
        const hours = Math.floor((diff % 86400) / 3600);
        const minutes = Math.floor((diff % 3600) / 60);
        const seconds = diff % 60;
        
        activeTimeElement.textContent = 
            `${days}d ${hours}h ${minutes}m ${seconds}s`;
    }
    
    // Update immediately
    updateActiveTime();
    
    // Update every second
    setInterval(updateActiveTime, 1000);

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

    // Signature canvas functionality
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