@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.secondary')
@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded p-6">
            <div class="mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ ucwords($freelancer->name) }}</h1>
                <a href="{{route('post.project.index', $freelancer)}}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-900">Post Project</a>
            </div>
            <p class="mb-3"><strong>Email:</strong> {{ $freelancer->email }}</p>
            <p class="mb-3"><strong>Skills:</strong>
                @foreach (explode(',', $freelancer->skills) as $skill)
                    <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                @endforeach
            </p>
            <p class="mb-3"><strong>Experience:</strong> {{ $freelancer->experience }} </p>
            <p class="mb-3"><strong>Location:</strong> {{ $freelancer->location }} </p>
            <!-- Freelancer Projects Section -->
            <div class="bg-white shadow rounded p-6 mb-3">
                <h2 class="text-xl font-bold mb-4">Projects by {{ $freelancer->name }}</h2>
                @if ($freelancer->projects->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($freelancer->projects as $project)
                            <div class="bg-gray-100 p-4 rounded shadow">
                                <h3 class="text-lg font-semibold">{{ $project->name }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($project->description, 100) }}</p>


                                @if ($project->images->count() > 0)
                                    <img src="{{ asset('storage/' . $project->images->first()->image) }}"
                                         alt="Project Image" class="w-full h-40 object-cover mt-2 rounded">
                                @endif

                                <a href="{{ route('projects.show', $project->id) }}"
                                   class="inline-block bg-purple-500 text-white px-3 py-1 rounded mt-3 hover:bg-blue-600">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No projects available.</p>
                @endif
            </div>
            @if(auth()->user()->id !== $freelancer->id)
                <!-- Start Chat Button -->
                <a href="{{ route('chat.index', ['otherUserId' => $freelancer->id]) }}"
                   class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Start Chat
                </a>
            @endif
        </div>
        <div class="bg-white shadow rounded p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">Review to {{ $freelancer->name }}</h2>
            <form action="{{ route('review.freelancer', $freelancer->id) }}" method="POST">
                @csrf
                 <?php
                 $myCurrentReview = $freelancer->reviews->firstWhere(function($element)
                 {
                      return $element->user_id === auth()->user()->id;
                 });
                 $reviewText = old('review', $myCurrentReview?->review)
                 ?>
                <div class="mb-4" x-data="
	{
		rating: {{$myCurrentReview?->rating ?? 1}},
		hoverRating:  {{$myCurrentReview?->rating ?? 1}},
		ratings: [{'amount': 1}, {'amount': 2}, {'amount': 3}, {'amount': 4,}, {'amount': 5}],
	}">
                    <div class="flex space-x-0">
                        <template x-for="(star, index) in ratings" :key="index">
                            <button
                                    type="button"
                                    @click="rating = star.amount" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating"
                                    aria-hidden="true"
                                    :title="star.label"
                                    class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline w-10 m-0 cursor-pointer"
                                    :class="{'text-gray-600': hoverRating >= star.amount, 'text-yellow-400': rating >= star.amount && hoverRating >= star.amount}">
                                <svg class="w-15 transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>

                        </template>
                    </div>
                <input type="hidden" name="rating" x-model="rating">
                </div>
                <div class="mb-2">
                     <textarea name="review" rows="4" class="w-full border rounded p-2"
                               required>{{$reviewText}}</textarea>

                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Submit Review
                </button>
            </form>
        </div>
    </div>
@endsection
