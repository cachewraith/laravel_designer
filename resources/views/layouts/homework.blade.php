<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Homework Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen font-['Inter']">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-600 via-violet-600 to-purple-700 text-white flex flex-col shadow-2xl">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">EduTrack</h1>
                        <p class="text-xs text-white/70">Homework System</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 px-4 py-4 space-y-2">
                <div class="text-xs font-semibold text-white/50 uppercase tracking-wider px-4 mb-2">Teacher</div>
                <a href="{{ route('homeworks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('homeworks.index') ? 'bg-white/20 shadow-lg shadow-black/10' : '' }}">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <span class="font-medium">All Homeworks</span>
                </a>
                <a href="{{ route('homeworks.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('homeworks.create') ? 'bg-white/20 shadow-lg shadow-black/10' : '' }}">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Create New</span>
                </a>
                
                <div class="text-xs font-semibold text-white/50 uppercase tracking-wider px-4 mt-6 mb-2">Student</div>
                <a href="{{ route('homeworks.student.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('homeworks.student.*') ? 'bg-white/20 shadow-lg shadow-black/10' : '' }}">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-400 to-pink-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">My Homeworks</span>
                </a>
            </nav>
            
            <div class="p-4">
                <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-rose-400 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-white/60">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-white/50 px-8 py-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">@yield('header', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
                            <span class="text-sm text-gray-600">{{ now()->format('l, F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-4 rounded-xl shadow-lg shadow-emerald-200 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-500 to-rose-500 text-white px-6 py-4 rounded-xl shadow-lg shadow-red-200 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-4 rounded-xl shadow-lg shadow-orange-200">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
