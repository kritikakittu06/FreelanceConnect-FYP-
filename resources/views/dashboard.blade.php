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
                                        <p class="text-gray-600 dark:text-gray-400">Status: {{ ucfirst($project->status) }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" data-modal-toggle="edit-project-modal-{{ $project->id }}">
                                            Edit
                                        </button>
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

    <!-- Add Project Modal -->
    <div id="add-project-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Add New Project</h2>
            <form action="{{ route('project.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Project Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 mt-2 border border-gray-300 dark:border-gray-600 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status" class="w-full p-2 mt-2 border border-gray-300 dark:border-gray-600 rounded" required>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#7F55E0] hover:bg-[#6A45C4] text-white py-2 px-4 rounded">Save Project</button>
                    <button type="button" class="ml-2 bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded" data-modal-toggle="add-project-modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Project Modal -->
    @foreach($projects->where('user_id', auth()->id()) as $project)

    <div id="edit-project-modal-{{ $project->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Edit Project</h2>
            <form action="{{ route('projects.update', $project->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Project Name</label>
                    <input type="text" id="name" name="name" value="{{ $project->name }}" class="w-full p-2 mt-2 border border-gray-300 dark:border-gray-600 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status" class="w-full p-2 mt-2 border border-gray-300 dark:border-gray-600 rounded" required>
                        <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#7F55E0] hover:bg-[#6A45C4] text-white py-2 px-4 rounded">Update Project</button>
                    <button type="button" class="ml-2 bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded" data-modal-toggle="edit-project-modal-{{ $project->id }}">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script>
        // Simple modal toggle script
        document.querySelectorAll('[data-modal-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-toggle');
                document.getElementById(modalId).classList.toggle('hidden');
            });
        });
    </script>
</x-app-layout>
