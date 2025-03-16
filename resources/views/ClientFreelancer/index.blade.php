@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.secondary')

@section('content')
    <!-- Hero Section (remains static or can be made dynamic as needed) -->
    <section class="relative bg-white-600 text-white py-20">
        <img alt="A vibrant and dynamic background image representing creativity and collaboration"
            class="absolute inset-0 w-full h-full object-cover opacity-50" height="600"
            src="https://storage.googleapis.com/a1aa/image/IMxeXHEp5K0z6walK8pZDoZAT2ZOCllxkuE3inSMxU4.jpg" width="1920" />
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl text-purple-600 font-bold mb-4">Find the Best Freelancers for Your Projects</h1>
            <p class="text-lg text-purple-600 mb-8">Browse through our talented freelancers and find the right fit for your
                project needs.</p>
            <a href="#" class="bg-purple-600 text-white-600 px-6 py-3 rounded-full font-semibold">Post a Project</a>
        </div>
    </section>

    <!-- Advanced Search Section (optional, can be connected to a search controller) -->
    <section class="py-10 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold">Find Freelancers</h2>
                <p class="text-gray-600">Search for the perfect freelancer for your job.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="GET" action="{{ route('freelancers.index') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="skills" value="{{ request('skills') }}"
                        placeholder="Skills (e.g., PHP, React)" class="border border-gray-300 p-2 rounded">
                    <input type="number" name="experience" value="{{ request('experience') }}"
                        placeholder="Min Experience (Years)" class="border border-gray-300 p-2 rounded">
                    <input type="text" name="budget" value="{{ request('budget') }}" placeholder="Max Budget "
                        class="border border-gray-300 p-2 rounded">
                    <input type="text" name="location" value="{{ request('location') }}"
                        placeholder="Location (e.g., New York)" class="border border-gray-300 p-2 rounded">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Search</button>
                </form>
            </div>
        </div>
    </section>




    <!-- Freelancers Listings Section (Dynamic) -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Our Top Freelancers</h2>
                <p class="text-gray-600">Browse through the profiles of our top freelancers.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($freelancers as $freelancer)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <!-- Freelancer Image (if profile_image is set; otherwise use a default image) -->
                        <img alt="{{ $freelancer->name }}'s Profile Picture" class="w-24 h-24 rounded-full mx-auto mb-4"
                            src="{{ $freelancer->profile_image ? asset('storage/' . $freelancer->profile_image) : asset('images/default-avatar.png') }}"
                            width="96" height="96" />

                        <h3 class="text-xl font-semibold mb-2 text-center">{{ $freelancer->name }}</h3>
                        <p class="text-gray-600 mb-4 text-center">{{ $freelancer->designation ?? 'Freelancer' }}</p>
                        <!-- Display a shortened version of the profile description -->
                        <p class="text-gray-600 mb-4">{{ Str::limit($freelancer->profile_description, 100) }}</p>
                        <!-- Display Skills (assumes skills stored as comma-separated values) -->
                        <div class="flex justify-center space-x-2 mb-4">
                            @if ($freelancer->skills)
                                @foreach (explode(',', $freelancer->skills) as $skill)
                                    <span
                                        class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="flex justify-center">
                            <form action="{{ route('rate.freelancer', $freelancer->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $uniqueId = 'rating-' . $freelancer->id . '-' . $i;
                                        @endphp
                                        <input type="radio" name="rating_{{ $freelancer->id }}"
                                            value="{{ $i }}" id="{{ $uniqueId }}" class="hidden"
                                            {{ old('rating_' . $freelancer->id) == $i ? 'checked' : '' }} required>
                                        <label for="{{ $uniqueId }}" class="cursor-pointer text-2xl star-label">
                                            ★
                                        </label>
                                    @endfor
                                </div>
                                <button type="submit"
                                    class="mt-2 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Submit Rating
                                </button>
                            </form>


                        </div>



                        <style>
                            .star-label {
                                color: #d1d5db;
                                /* Default gray color */
                                transition: color 0.2s;
                            }

                            input[type="radio"]:checked+label,
                            input[type="radio"]:checked+label~label {
                                color: #fbbf24;
                                /* Yellow color for selected stars */
                            }

                            label:hover,
                            label:hover~label {
                                color: #fbbf24 !important;
                                /* Ensure hover effect */
                                cursor: pointer;
                            }
                        </style>



                        <!-- Freelancer's Profile Rating Display -->
                        <!-- Freelancer's Profile Rating Display -->
                        <div class="flex justify-center items-center mb-4">
                            @php
                                // Get the average rating from the model
                                $averageRating = $freelancer->averageRating();
                                $totalRatings = $freelancer->totalRatings();
                                $fullStars = floor($averageRating); // Full stars (integer part)
                                $halfStar = $averageRating - $fullStars >= 0.5; // If 0.5 or more, show half star
                                $emptyStars = 5 - ceil($averageRating); // Empty stars remaining
                            @endphp

                            <!-- Full Stars -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-yellow-500"></i>
                            @endfor

                            <!-- Half Star -->
                            @if ($halfStar)
                                <i class="fas fa-star-half-alt text-yellow-500"></i>
                            @endif

                            <!-- Empty Stars -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="fas fa-star text-gray-300"></i>
                            @endfor

                            <!-- Rating display -->
                            <span class="ml-2 text-gray-600">({{ number_format($averageRating, 1) }} from
                                {{ $totalRatings }} ratings)</span>
                        </div>



                        <!-- View Profile Link: This should lead to a dynamic freelancer profile page where the client can then start a chat -->
                        <a href="{{ route('freelancer.profile', ['id' => $freelancer->id]) }}"
                            class="text-purple-600 font-semibold block text-center">
                            View Profile
                        </a>
                        <!-- Post Project Button -->
                        <button onclick="openModal({{ $freelancer->id }})"
                            class="mt-4 px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Post Project
                        </button>

                        <!-- Post Project Modal (Hidden by Default) -->
                        <div id="postProjectModal-{{ $freelancer->id }}"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                <h2 class="text-2xl font-semibold mb-4">Post a Project</h2>

                                <form id="postProjectForm-{{ $freelancer->id }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

                                    <label class="block mb-2 font-semibold">Project Title:</label>
                                    <input type="text" name="title" class="w-full border p-2 rounded mb-3" required>

                                    <label class="block mb-2 font-semibold">Project Description:</label>
                                    <textarea name="description" class="w-full border p-2 rounded mb-3" required></textarea>

                                    <label class="block mb-2 font-semibold">Budget:</label>
                                    <input type="number" name="budget" class="w-full border p-2 rounded mb-3" required>

                                    <label class="block mb-2 font-semibold">Deadline:</label>
                                    <input type="date" name="deadline" class="w-full border p-2 rounded mb-3"
                                        required>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="closeModal({{ $freelancer->id }})"
                                            class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">
                                            Submit Project
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Attach form submit event listener for each freelancer's post project form
                                document.querySelectorAll("[id^='postProjectForm']").forEach(form => {
                                    form.addEventListener("submit", function(event) {
                                        event.preventDefault(); // Prevent default form submission

                                        let formData = new FormData(this); // Capture form data
                                        let freelancerId = formData.get(
                                            "freelancer_id"); // Extract freelancer_id from the form data

                                        // Make the fetch request to store the project
                                        fetch("{{ route('post.project') }}", {
                                                method: "POST",
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector(
                                                        'meta[name="csrf-token"]').getAttribute('content'),
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    alert("Project posted successfully!");
                                                } else {
                                                    console.error("Error:", data);
                                                    alert("Failed to post project.");
                                                }
                                            })
                                            .catch(error => console.error("Fetch error:", error));

                                    });
                                });
                            });

                            // Open modal
                            function openModal(freelancerId) {
                                document.getElementById(`postProjectModal-${freelancerId}`).classList.remove('hidden');
                            }

                            // Close modal
                            function closeModal(freelancerId) {
                                document.getElementById(`postProjectModal-${freelancerId}`).classList.add('hidden');
                            }
                        </script>


                    </div>
                @endforeach
            </div>
            <!-- Optional: Pagination links -->
            <div class="mt-8">
                {{ $freelancers->links() }}
            </div>
        </div>
    </section>

    <!-- Testimonials Section (can be dynamic if you have testimonials in your database) -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">What Our Clients Say</h2>
                <p class="text-gray-600">Hear from our satisfied clients.</p>
            </div>
            <!-- Testimonials can also be looped here dynamically if needed -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Static testimonials (or convert them to dynamic if stored in DB) -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"John Doe did an amazing job on our website. He was professional, timely,
                        and delivered a high-quality product. Highly recommend!"</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4"
                            src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg"
                            width="40" height="40" />
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">CEO, Company</p>
                        </div>
                    </div>
                </div>
                <!-- Repeat for other testimonials... -->
            </div>
        </div>
    </section>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($freelancers as $freelancer)
            @foreach ($freelancer->reviews as $review)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"{{ $review->review }}"</p> <!-- Display the review -->
                    <div class="flex items-center">
                        <!-- Display client profile image -->
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4"
                            src="{{ asset('storage/' . $review->client->profile_image) }}" width="40"
                            height="40" />

                        <div>
                            <p class="text-gray-700 font-semibold">{{ $review->client->name }}</p>
                            <p class="text-gray-600 text-sm">
                                {{ $review->client->role == 'client' ? 'Client' : 'User' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach



    </div>

    </div>
    </section>


    <!-- Call to Action Section (static or dynamic as needed) -->
    <section class="py-20 bg-purple-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-8">Post your project today and find the perfect freelancer to bring your ideas to life.
            </p>
            <a href="#" class="bg-white text-purple-600 px-6 py-3 rounded-full font-semibold">Post a Project</a>
        </div>
    </section>
@endsection


{{--
@extends('layouts.secondary')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-white-600 text-white py-20">
        <img alt="A vibrant and dynamic background image representing creativity and collaboration" class="absolute inset-0 w-full h-full object-cover opacity-50" height="600" src="https://storage.googleapis.com/a1aa/image/IMxeXHEp5K0z6walK8pZDoZAT2ZOCllxkuE3inSMxU4.jpg" width="1920"/>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl text-purple-600 font-bold mb-4">Find the Best Freelancers for Your Projects</h1>
            <p class="text-lg text-purple-600 mb-8">Browse through our talented freelancers and find the right fit for your project needs.</p>
            <a href="#" class="bg-purple-600 text-white-600 px-6 py-3 rounded-full font-semibold">Post a Project</a>
        </div>
    </section>

    <!-- Advanced Search Section -->
    <section class="py-10 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold">Advanced Search</h2>
                <p class="text-gray-600">Search for freelancers based on specific criteria.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" placeholder="Skills" class="border border-gray-300 p-2 rounded">
                    <input type="text" placeholder="Experience" class="border border-gray-300 p-2 rounded">
                    <input type="text" placeholder="Project Budget" class="border border-gray-300 p-2 rounded">
                    <input type="text" placeholder="Location" class="border border-gray-300 p-2 rounded">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Search</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Freelancers Listings Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Our Top Freelancers</h2>
                <p class="text-gray-600">Browse through the profiles of our top freelancers.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of John Doe, a skilled web developer" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/u2aVXa1peromGcYiPJPbXeYq0elN6ytaQUqYFaLjmR4.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">John Doe</h3>
                    <p class="text-gray-600 mb-4 text-center">Web Developer</p>
                    <p class="text-gray-600 mb-4">John is a skilled web developer with over 5 years of experience in creating responsive and user-friendly websites.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">HTML</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">CSS</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">JavaScript</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(4.5)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of Jane Smith, a creative UI/UX designer" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/mjC19c_CJ9Rynmxtcmbwi9mMCs50h6gbABU1QLht3UU.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">Jane Smith</h3>
                    <p class="text-gray-600 mb-4 text-center">UI/UX Designer</p>
                    <p class="text-gray-600 mb-4">Jane is a creative UI/UX designer with a passion for creating intuitive and visually appealing user interfaces.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Figma</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Sketch</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Adobe XD</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(5.0)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of Michael Brown, an SEO specialist" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/OdX55WUaK_osTv2mRuLRAu0Nq2U1UbV4y3-OkI0NDZ8.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">Michael Brown</h3>
                    <p class="text-gray-600 mb-4 text-center">SEO Specialist</p>
                    <p class="text-gray-600 mb-4">Michael is an SEO specialist with a proven track record of improving website rankings and driving organic traffic.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">SEO</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Google Analytics</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Content Marketing</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(5.0)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of Emily Davis, a professional content writer" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/i9YnEC0cUyLlXfgmcwqharmwTakmhvtx9piSKAA07dE.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">Emily Davis</h3>
                    <p class="text-gray-600 mb-4 text-center">Content Writer</p>
                    <p class="text-gray-600 mb-4">Emily is a professional content writer with a knack for creating engaging and informative blog posts and articles.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Blog Writing</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Copywriting</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">SEO Writing</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(4.5)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of David Wilson, a talented graphic designer" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">David Wilson</h3>
                    <p class="text-gray-600 mb-4 text-center">Graphic Designer</p>
                    <p class="text-gray-600 mb-4">David is a talented graphic designer with a flair for creating eye-catching marketing materials and branding assets.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Photoshop</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Illustrator</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">InDesign</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(5.0)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img alt="Portrait of Sarah Johnson, a social media manager" class="w-24 h-24 rounded-full mx-auto mb-4" height="96" src="https://storage.googleapis.com/a1aa/image/ZhRqxFjJuDvtW48R4lJAH4jFXWSbFyKHSurNwMH2XA4.jpg" width="96"/>
                    <h3 class="text-xl font-semibold mb-2 text-center">Sarah Johnson</h3>
                    <p class="text-gray-600 mb-4 text-center">Social Media Manager</p>
                    <p class="text-gray-600 mb-4">Sarah is a social media manager with expertise in managing and growing social media accounts for various brands.</p>
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Social Media</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Content Creation</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">Analytics</span>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-2 text-gray-600">(5.0)</span>
                    </div>
                    <a href="#" class="text-purple-600 font-semibold block text-center">View Profile</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">What Our Clients Say</h2>
                <p class="text-gray-600">Hear from our satisfied clients.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"John Doe did an amazing job on our website. He was professional, timely, and delivered a high-quality product. Highly recommend!"</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">CEO, Company</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"Jane Smith's design skills are top-notch. She created a beautiful and user-friendly interface for our app. We couldn't be happier!"</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">Product Manager, Company</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"Michael Brown's SEO expertise helped us rank higher on search engines and drive more traffic to our site. Excellent work!"</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">Marketing Director, Company</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"Emily Davis is a fantastic content writer. Her articles are engaging and well-researched. We saw a significant increase in our blog traffic."</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">Content Manager, Company</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"David Wilson's graphic design work is outstanding. He created stunning visuals for our marketing campaigns. Highly recommend!"</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">Creative Director, Company</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">"Sarah Johnson's social media management skills are exceptional. She helped us grow our social media presence significantly."</p>
                    <div class="flex items-center">
                        <img alt="Portrait of a satisfied client" class="w-10 h-10 rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/4AFXNCKdQ6IJWLHmHgolCKg1LmJ6l3CUWwYkjnXUDS8.jpg" width="40"/>
                        <div>
                            <p class="text-gray-700 font-semibold">Client Name</p>
                            <p class="text-gray-600 text-sm">Social Media Manager, Company</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-purple-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-8">Post your project today and find the perfect freelancer to bring your ideas to life.</p>
            <a href="#" class="bg-white text-purple-600 px-6 py-3 rounded-full font-semibold">Post a Project</a>
        </div>
    </section>

@endsection
 --}}
