<x-app-layout>
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-grow bg-gray-100 dark:bg-gray-900">
            <div class="p-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Welcome, {{ auth()->user()->name }}!</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Manage your profile, explore job offers, and track your active projects.</p>

                        <!-- Active Projects Section -->
                        <div class="mt-8">
                            <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200">Your Active Projects</h4>


                            <!-- Projects List -->
                            <div class="mt-4 space-y-4">
                                @foreach($projects as $project)
                                <!-- Project -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md flex justify-between items-center">
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $project->name }}</h5>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{route('projects.edit', $project)}}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" data-modal-toggle="edit-project-modal-{{ $project->id }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
