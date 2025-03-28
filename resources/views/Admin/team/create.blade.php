<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Add Team Member</h2>
        <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium">Name</label>
                <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-purple-300" placeholder="Enter name" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Role</label>
                <input type="text" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-purple-300" placeholder="Enter role" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Description</label>
                <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-purple-300" placeholder="Enter description"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Upload Image</label>
                <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white font-semibold p-3 rounded-lg hover:bg-purple-700 transition-all duration-300">Save</button>
        </form>
    </div>
</x-app-layout>
