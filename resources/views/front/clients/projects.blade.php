@extends('layouts.secondary')

@section('content')
<div class="container mx-auto my-5">
    <h2 class="text-center text-4xl font-semibold text-purple-600 mb-12">Approved Projects</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Project 1 -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-transparent hover:border-purple-600 transition-all duration-300">
            <div class="flex items-center mb-4">
                <i class="fas fa-laptop-code text-purple-600 text-3xl mr-3"></i>
                <h5 class="text-xl font-semibold text-purple-600">Website Development</h5>
            </div>
            <p class="text-lg mb-2"><strong>Description:</strong> Build a modern e-commerce platform.</p>
            <p class="text-lg mb-2"><strong>Freelancer ID:</strong> F123</p>
            <p class="text-lg mb-2"><strong>Budget:</strong> $1500.00</p>
            <p class="text-lg mb-4"><strong>Deadline:</strong> June 15, 2025</p>
            <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition-all duration-300">
                <i class="fas fa-dollar-sign mr-2"></i> Pay Now
            </button>
        </div>

        <!-- Project 2 -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-transparent hover:border-purple-600 transition-all duration-300">
            <div class="flex items-center mb-4">
                <i class="fas fa-mobile-alt text-purple-600 text-3xl mr-3"></i>
                <h5 class="text-xl font-semibold text-purple-600">Mobile App Design</h5>
            </div>
            <p class="text-lg mb-2"><strong>Description:</strong> Design a mobile app for iOS and Android.</p>
            <p class="text-lg mb-2"><strong>Freelancer ID:</strong> F124</p>
            <p class="text-lg mb-2"><strong>Budget:</strong> $2000.00</p>
            <p class="text-lg mb-4"><strong>Deadline:</strong> July 1, 2025</p>
            <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition-all duration-300">
                <i class="fas fa-dollar-sign mr-2"></i> Pay Now
            </button>
        </div>

        <!-- Project 3 -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-transparent hover:border-purple-600 transition-all duration-300">
            <div class="flex items-center mb-4">
                <i class="fas fa-search text-purple-600 text-3xl mr-3"></i>
                <h5 class="text-xl font-semibold text-purple-600">SEO Optimization</h5>
            </div>
            <p class="text-lg mb-2"><strong>Description:</strong> Enhance SEO for existing website.</p>
            <p class="text-lg mb-2"><strong>Freelancer ID:</strong> F125</p>
            <p class="text-lg mb-2"><strong>Budget:</strong> $1200.00</p>
            <p class="text-lg mb-4"><strong>Deadline:</strong> August 20, 2025</p>
            <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition-all duration-300">
                <i class="fas fa-dollar-sign mr-2"></i> Pay Now
            </button>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
