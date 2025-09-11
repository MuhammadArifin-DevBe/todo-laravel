<x-app-layout title="Edit Todo">
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Todo') }}
    </h2>
    </x-slot>

    <!-- Form Edit -->
    <div class="flex justify-center items-center min-h-[50vh]">
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
            <form action="{{ route('todo.edit', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="todo-name" class="mb-2 text-sm font-medium text-gray-900 sr-only">Todo Name</label>
                <input type="text" id="todo-name" name="name" value="{{ $todo->name }}"
                    class="mb-2 block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Edit todo..." required />

                <label for="todo-description" class="mt-4 mb-2 text-sm font-medium text-gray-900 sr-only">Description</label>
                <textarea id="todo-description" name="description" rows="3"
                    class="mb-2 block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Edit description...">{{ $todo->description }}</textarea>

                <label for="todo-status" class="mt-4 mb-2 text-sm font-medium text-gray-900 sr-only">Status</label>
                <select id="todo-status" name="is_done"
                    class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1" {{ $todo->is_done ? 'selected' : '' }}>Selesai</option>
                    <option value="0" {{ !$todo->is_done ? 'selected' : '' }}>Belum selesai</option>
                </select>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('todo.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>