<x-app-layout>
    <div class="flex h-screen">
        <main class="dashboard-content w-full">
            <div class="dashboard-header">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Projects from Client</h3>
            </div>
            <div class="dashboard-table-container overflow-x-auto">
                <table class="w-full min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Project Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Client</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Budget</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Deadline</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($projects as $project)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $project->project_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $project->client->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">${{ $project->budget }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $project->deadline }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                    {{ $project->project_description }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <form action="{{ route('freelancer.projects.accept', $project->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirmAccept()">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-green-500 hover:text-green-700 border border-green-500 hover:bg-green-100 rounded-md">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('freelancer.projects.reject', $project->id) }}" method="POST" class="inline-block ml-2"
                                        onsubmit="return confirmReject()">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-500 hover:text-red-700 border border-red-500 hover:bg-red-100 rounded-md">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function confirmAccept() {
            return confirm("Are you sure you want to accept this project?");
        }

        function confirmReject() {
            return confirm("Are you sure you want to reject this project?");
        }
    </script>
</x-app-layout>
