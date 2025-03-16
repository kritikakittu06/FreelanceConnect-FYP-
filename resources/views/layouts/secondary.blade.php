<?php
use Illuminate\Support\Facades\Route;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Font Awesome for profile icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="text-2xl font-bold text-purple-600">FreelanceConnect</div>

            <nav class="hidden md:flex space-x-4">
                <!-- Your dropdowns and links go here -->
                <a class="text-gray-700 hover:text-purple-600" href="{{ route('freelancers.index') }}">Find talent</a>
                <a class="text-gray-700 hover:text-purple-600" href="#">Find work</a>
                <a class="text-gray-700 hover:text-purple-600" href="{{ route('about') }}">Why FreelanceConnect</a>

                <a class="text-gray-700 hover:text-purple-600" href="{{ route('payment.index') }}">Pricing</a>
            </nav>

            <!-- Authentication Links -->
            @if (Route::has('login'))
                <div class="flex space-x-4">
                    @auth

                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-purple-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-purple-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-purple-600">Sign Up</a>
                        @endif
                    @endauth

                    @if(auth()->user()->role === 'client')
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-user-edit"></i> <!-- Profile Edit Icon -->
                    </a>
                @endif
                </div>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        @yield('content') <!-- This is where the content of the page will go -->
    </div>

</body>
</html>
