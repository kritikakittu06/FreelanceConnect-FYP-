<x-app-layout>
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-grow bg-gray-100 dark:bg-gray-900">
            <div class="p-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Welcome, {{ auth()->user()->name }}!</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Manage your profile, explore job offers, and track your active projects.</p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('Freelancer.todo')
