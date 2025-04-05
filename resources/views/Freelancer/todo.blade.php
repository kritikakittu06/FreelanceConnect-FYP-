@extends('layouts.secondary')

@section('content')
<div class="container mx-auto py-16">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">To-Do List</h1>

    <!-- To-Do List Form -->
    <div class="mb-6">
        <form id="todo-form" class="flex items-center space-x-4">
            <input type="text" id="todo-input" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add a new task">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add Task</button>
        </form>
    </div>

    <!-- To-Do List Table -->
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Task</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="todo-table-body">
                <!-- Tasks will be dynamically added here -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const todoForm = document.getElementById('todo-form');
        const todoInput = document.getElementById('todo-input');
        const todoTableBody = document.getElementById('todo-table-body');

        todoForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const task = todoInput.value.trim();
            if (task) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-4 px-6 border-b border-gray-200">${task}</td>
                    <td class="py-4 px-6 border-b border-gray-200 text-center">
                        <button class="text-red-500 hover:text-red-700 transition duration-150" onclick="this.closest('tr').remove();">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                todoTableBody.appendChild(row);
                todoInput.value = '';
            }
        });
    });
</script>
@endsection
