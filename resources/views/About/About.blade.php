@php
    $teamMembers = App\Models\TeamMember::all();
@endphp

@extends('layouts.secondary')

@section('title', 'About Us - Freelance Connect')

@section('content')
<!-- Hero Section with Background Video -->
<section class="relative bg-purple-600 text-white py-20">
    <div class="absolute inset-0 overflow-hidden">
        <video autoplay muted loop class="w-full h-full object-cover">
            <source src="https://www.w3schools.com/html/mov_bbb.mp4"  type="video/mp4">
        </video>
    </div>
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4 text-black">About Freelance Connect</h1>
        <p class="text-lg mb-8 text-black">Connecting clients with top freelancers from around the world, enabling creativity and collaboration.</p>
    </div>
</section>

<section class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <!-- Section Heading -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-purple-600 mb-4">Our Mission: Empowering Freelancers</h2>
            <p class="text-xl text-gray-700">We bridge the gap between businesses and top freelancers from around the world, enabling seamless collaboration for exceptional results.</p>
        </div>

        <!-- Split Layout with Image -->
        <div class="grid grid-cols-1 md:grid-cols-2  items-center">
            <!-- Left Side: Freelance Image -->
            <div class="relative flex justify-center w-full">
                <img src="https://i.pinimg.com/474x/ee/14/e1/ee14e135e9c0cd7dd51d1057d92fe129.jpg">
            </div>

            <!-- Right Side: Text Content -->
            <div class="flex flex-col justify-center px-4">
                <h3 class="text-3xl font-semibold text-gray-800 mb-6">What Makes Freelance Connect Unique?</h3>
                <p class="text-lg text-gray-600 mb-6">
                    Freelance Connect isn’t just another freelancing platform. We are a global network of talented professionals who work across industries and time zones, providing flexibility and top-quality results. Whether you're a freelancer or a business, we empower you to work smart, collaborate effectively, and achieve success.
                </p>

                <!-- Bullet Points for Key Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <span class="bg-blue-600 text-white p-2 rounded-full mr-3"><i class="fas fa-users"></i></span>
                        <p class="text-gray-600">Access a global pool of top talent</p>
                    </div>
                    <div class="flex items-center">
                        <span class="bg-blue-600 text-white p-2 rounded-full mr-3"><i class="fas fa-globe"></i></span>
                        <p class="text-gray-600">Collaborate in real-time across borders</p>
                    </div>
                    <div class="flex items-center">
                        <span class="bg-blue-600 text-white p-2 rounded-full mr-3"><i class="fas fa-tasks"></i></span>
                        <p class="text-gray-600">Flexible project and contract management</p>
                    </div>
                    <div class="flex items-center">
                        <span class="bg-blue-600 text-white p-2 rounded-full mr-3"><i class="fas fa-laptop-house"></i></span>
                        <p class="text-gray-600">Work from anywhere, anytime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Our Team Section with Interactive Hover Effects -->
<section class="py-16">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-4">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($teamMembers as $member)
                <div class="bg-white p-6 rounded-lg shadow-md hover:scale-105 transition duration-300">
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-full mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $member->name }}</h3>
                    <p class="text-gray-600">{{ $member->role }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action (Join Us) Section -->
<section class="bg-purple-600 text-white py-16">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-lg mb-8">Join Freelance Connect today and start collaborating with top talents worldwide!</p>
        <a href="/register" class="bg-white text-blue-600 py-2 px-6 rounded-lg font-semibold">Join Now</a>
    </div>
</section>

@endsection
