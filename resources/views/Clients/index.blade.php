<x-app-layout>
    <div class="flex h-screen">
        <main class="dashboard-content w-full">
            <div class="dashboard-header">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Clients</h3>
            </div>
            <div class="dashboard-table-container overflow-x-auto">
                <table class="w-full min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($clients as $client)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $client->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $client->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('clients.show', $client->id) }}"
                                   class="inline-block px-4 py-2 text-sm font-semibold text-blue-500 hover:text-blue-700 border border-blue-500 hover:bg-blue-100 rounded-md">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>
