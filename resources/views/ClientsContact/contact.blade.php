@extends('layouts.secondary')

@section('content')
<div class="container mx-auto py-16 relative min-h-screen">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 -z-10">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
             alt="Freelance workspace background"
             class="w-full h-full object-cover opacity-25">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/60 to-purple-900/60"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-white mb-4 drop-shadow-xl animate-fade-in-down">Let's Build Something Amazing</h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto">Your friendly freelance expert based in categories, ready to bring your ideas to life.</p>
        </div>

        <div class="flex flex-wrap -mx-4">
            <!-- Contact Form -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-500 border border-gray-100/50">
                    <h2 class="text-3xl font-bold mb-6 text-indigo-900 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Contact Us</h2>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="relative">
                            <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                            <input type="text" name="name" id="name"
                                   class="mt-2 block w-full border-2 border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 bg-white/50"
                                   placeholder="John Doe">
                            <span class="absolute right-4 top-12 text-gray-400"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email"
                                   class="mt-2 block w-full border-2 border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 bg-white/50"
                                   placeholder="john@example.com">
                            <span class="absolute right-4 top-12 text-gray-400"><i class="fas fa-envelope"></i></span>
                        </div>
                        <div class="relative">
                            <label for="message" class="block text-sm font-medium text-gray-700"> Message </label>
                            <textarea name="message" id="message" rows="4"
                                      class="mt-2 block w-full border-2 border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 bg-white/50"
                                      placeholder="Tell me about your vision..."></textarea>
                            <span class="absolute right-4 top-12 text-gray-400"><i class="fas fa-comment"></i></span>
                        </div>
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="font-semibold"> Send Message </span>
                            <i class="fas fa-rocket ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-gray-100/50">
                    <h2 class="text-3xl font-bold mb-6 text-indigo-900 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Your Questions Answered</h2>
                    <div class="space-y-8">
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-code mr-2 text-purple-600"></i> What can I build for you?
                            </h3>
                            <p class="text-gray-600">Custom websites, mobile apps, and digital solutions tailored to your business needs.</p>
                        </div>
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-clock mr-2 text-purple-600"></i> How fast can I deliver?
                            </h3>
                            <p class="text-gray-600">Most projects are completed in 1-4 weeks, with rush options available.</p>
                        </div>
                        <div class="transform hover:-translate-y-1 transition-all duration-300">
                            <h3 class="font-semibold text-xl text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-handshake mr-2 text-purple-600"></i> Ready to collaborate?
                            </h3>
                            <p class="text-gray-600">Contact me today, and let’s discuss your project over a virtual coffee!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Section -->
        <div class="mt-16">
            <div class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-gray-100/50">
                <h2 class="text-3xl font-bold mb-6 text-indigo-900 text-center bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Based in Kathmandu</h2>
                <div id="map" class="w-full h-96 rounded-xl overflow-hidden shadow-lg"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 1s ease-out;
    }
</style>
@endsection

@section('scripts')
<script>
    function initMap() {
        // Kathmandu coordinates: 27.7172° N, 85.3240° E
        var kathmandu = {lat: 27.7172, lng: 85.3240};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: kathmandu,
            styles: [
                {"elementType": "geometry", "stylers": [{"color": "#f5f5f5"}]},
                {"elementType": "labels.text.fill", "stylers": [{"color": "#616161"}]},
                {"elementType": "labels.text.stroke", "stylers": [{"color": "#f5f5f5"}]},
                {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#e9e9e9"}]},
                {"featureType": "road", "elementType": "geometry", "stylers": [{"color": "#ffffff"}]}
            ]
        });
        var marker = new google.maps.Marker({
            position: kathmandu,
            map: map,
            animation: google.maps.Animation.BOUNCE,
            title: "Kathmandu, Nepal"
        });
    }
</script>
<script async defer src="https://fonts.gstatic.com/s/i/googlematerialicons/location_pin/v5/24px.svg"></script>
@endsection