<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @include('_partials.common-styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @stack('styles')

  

</head>
<body class="font-sans bg-gray-100">
<header class="bg-white shadow">
    <div class="container py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="text-2xl font-bold text-purple-600"><a href="{{route('welcome')}}">{{config('app.name')}}</a></div>
        <!-- Main Navigation (visible on md and up) -->
        <nav class="hidden md:flex space-x-4">
            @auth
                @if(auth()->user()->isClient())
                    <a class="text-gray-700 hover:text-purple-600" href="{{ route('clients.freelancers.index') }}">
                        Find talent
                    </a>
                @endif
            @endauth
            <a class="text-gray-700 hover:text-purple-600" href="{{route('about')}}">
                Why FreelanceConnect
            </a>
            @auth
                @if(auth()->user()->isClient())
                    <a class="text-gray-700 hover:text-purple-600" href="{{ route('clients.post-projects') }}">
                        Projects
                    </a>
                @endif
            @endauth
        </nav>
        <!-- Authentication Links -->
        <div class="flex space-x-4">
            @auth
                <a href="{{ auth()->user()->getDefaultRoute() }}"
                   class="text-gray-700 hover:text-purple-600">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-purple-600">Logout</button>
                </form>
                @if(auth()->user()->isClient())
                    <a href="{{ route('clients.profile.edit') }}" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-user-edit"></i>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600">Log in</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-purple-600">Sign Up</a>
            @endauth
        </div>
    </div>
</header>
<div class="min-h-[calc(100vh-136px)]">
@yield('content')
</div>
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto px-4 text-center">
        <p>&copy; {{date('Y')}} {{config('app.name')}}. All rights reserved.</p>
    </div>
</footer>
@include('_partials.common-scripts')
@stack('scripts')
</body>
</html>
