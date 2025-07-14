@extends('layouts.divisi')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Manager Dashboard</h1>
                <p class="mt-2 text-sm text-gray-600">Welcome back! Here's your overview.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pending Memos Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Memos</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">{{ $pendingMemos ?? 0 }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('manager.memo.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Approved Memos Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Approved Memos</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">{{ $approvedMemos ?? 0 }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Memos Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-all duration-300 hover:shadow-md">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-3 rounded-md">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Rejected Memos</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">{{ $rejectedMemos ?? 0 }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Simple Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- View Memos -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900">Manage Memos</h3>
                        <p class="mt-2 text-sm text-gray-600">Review and process pending memos.</p>
                        <div class="mt-4">
                            <a href="{{ route('manager.memo.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                Go to Memos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Create New -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900">Create New</h3>
                        <p class="mt-2 text-sm text-gray-600">Draft a new memo or document.</p>
                        <div class="mt-4">
                            <a href="{{ route('manager.memo.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Create Memo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reports -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900">Reports</h3>
                        <p class="mt-2 text-sm text-gray-600">View memo statistics and reports.</p>
                        <div class="mt-4">
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700">
                                View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection