@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Incidents</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_incidents'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pending Incidents</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_incidents'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Verified Incidents</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['verified_incidents'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Incidents by Category -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Incidents by Category</h3>
            <div class="space-y-3">
                @foreach($incidentsByCategory as $category)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ ucfirst($category->category) }}</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($category->count / $stats['total_incidents']) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $category->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Incidents by Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Incidents by Status</h3>
            <div class="space-y-3">
                @foreach($incidentsByStatus as $status)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ ucfirst($status->status) }}</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($status->count / $stats['total_incidents']) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $status->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Incidents -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Incidents</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentIncidents as $incident)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $incident->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $incident->user->name ?? 'Unknown User' }}</p>
                                <p class="text-xs text-gray-400">{{ $incident->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($incident->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($incident->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ $incident->status_label }}
                                </span>
                                @if($incident->is_verified)
                                    <i class="fas fa-check-circle text-green-500"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500">
                        No recent incidents
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.incidents.index') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    View all incidents →
                </a>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentUsers as $user)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ $user->name }}&background=3b82f6&color=fff" alt="{{ $user->name }}">
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->is_active) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($user->is_verified)
                                    <i class="fas fa-check-circle text-green-500"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500">
                        No recent users
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    View all users →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
