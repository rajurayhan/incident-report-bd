<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Incident Report Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            </div>
            
            <nav class="mt-6">
                <div class="px-6 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
                </div>
                
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-users mr-3"></i>
                            Users
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.incidents.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.incidents.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Incidents
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.comments.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.comments.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-comments mr-3"></i>
                            Comments
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.verifications.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.verifications.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-check-circle mr-3"></i>
                            Verifications
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.media.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.media.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-images mr-3"></i>
                            Media
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.alerts.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.alerts.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-bell mr-3"></i>
                            Alerts
                        </a>
                    </li>
                </ul>
                
                <div class="px-6 mt-8 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System</h3>
                </div>
                
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.roles.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.roles.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-user-shield mr-3"></i>
                            Roles
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.permissions.index') }}" 
                           class="flex items-center px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.permissions.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-key mr-3"></i>
                            Permissions
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                        @hasSection('breadcrumb')
                            <nav class="mt-1">
                                @yield('breadcrumb')
                            </nav>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff" alt="{{ auth()->user()->name }}">
                                <span class="ml-2">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                        </div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-home"></i>
                        </a>
                        
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            <div>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Add any global JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
