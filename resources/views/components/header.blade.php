<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    
    {{-- Memuat Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Font Tambahan (Opsional untuk estetika) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    {{-- NAVBAR SECTION --}}
    <nav class="bg-white border-b border-blue-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo / Brand --}}
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-blue-600 tracking-tight">Admin<span class="text-slate-700">Panel</span></span>
                    </div>
                    
                    {{-- Navigation Links --}}
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        {{-- Menu Employee --}}
                        <a href="{{ route('admin.employeeList') }}" 
                           class="{{ request()->is('admin/petugas*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:border-blue-300 hover:text-blue-500' }} 
                                  inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                            Employee
                        </a>

                        {{-- Dropdown Report --}}
                        <div class="relative group inline-flex items-center h-full">
                            <button class="{{ request()->is('admin/report*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:border-blue-300 hover:text-blue-500' }}
                                           inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium focus:outline-none transition duration-150 ease-in-out">
                                <span>Report</span>
                                <svg class="ml-2 h-4 w-4 transform group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Dropdown Menu Content --}}
                            <div class="absolute left-0 top-16 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform z-50 origin-top-left">
                                <div class="py-1">
                                    <a href="{{ route('admin.memberReport') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                        Member Report
                                    </a>
                                    <a href="{{ route('admin.nonMemberReport') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                        Non-Member Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- User Profile Dropdown --}}
                <div class="flex items-center">
                    <div class="ml-3 relative group">
                        {{-- Trigger: Avatar Image --}}
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-blue-300 transition duration-150 ease-in-out items-center gap-2">
                            <span class="hidden md:block text-sm font-medium text-slate-600">Admin User</span>
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Admin+Panel&background=2563eb&color=fff" alt="User Avatar">
                        </button>

                        {{-- Dropdown Menu Profile --}}
                        <div class="absolute right-0 top-10 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform z-50 origin-top-right">
                            <div class="py-1 bg-white rounded-md">
                                <div class="px-4 py-2 text-xs text-slate-400 border-b border-slate-100">
                                    Kelola Akun
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                    Profile Saya
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                    Pengaturan
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                
                                {{-- Form Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition font-medium">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content Start --}}
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">