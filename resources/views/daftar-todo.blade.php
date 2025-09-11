<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="flex">
        @php
        $today = now();
        @endphp
        <div class="w-1/4 p-4 border-r space-y-6">
            <div>
                <h2 class="font-bold text-lg mb-2">Create Todo</h2>
                <form action="{{ route('todo.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="name"
                            class="mb-2 block w-full p-3 text-sm text-gray-900 rounded-lg border border-gray-300"
                            placeholder="tulis nama todo..." />

                        <input type="text" name="description"
                            class="block w-full p-3 text-sm text-gray-900 rounded-lg border border-gray-300"
                            placeholder="opsional deskripsi..." />
                    </div>
                    <div class="flex justify-end gap-x-2">
                        <button type="reset" class="px-4 py-1 rounded-xl bg-white border border-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-1 rounded-xl bg-blue-700 text-white">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-3/4 p-6">
            <h2 class="font-bold text-lg mb-4">Tugas {{ $today->translatedFormat('l, d F Y') }}</h2>

            @forelse ($todos as $todo)
            <x-item-list :todo="$todo" />
            @empty
            <p class="text-gray-500">Belum ada tugas.</p>
            @endforelse
        </div>
    </div>

    <script>
        function openView(title, desc, date) {
            document.getElementById('viewTitle').innerText = title;
            document.getElementById('viewDate').innerText = date;
            document.getElementById('viewDesc').innerText = desc;
            document.getElementById('modalView').classList.remove('hidden');
        }

        function closeView() {
            document.getElementById('modalView').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[data-idtodo]');
            checkboxes.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    let todoId = this.getAttribute('data-idtodo');
                    let isChecked = this.checked;

                    if (confirm("Are you sure you want to mark this task as completed?")) {
                        sendComplete(todoId, isChecked ? 1 : 0, this);
                    }
                });
            });
        });

        function sendComplete(todoId, isDone, checkbox) {
            fetch(`/todo/${todoId}/done`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_done: isDone
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Request failed');
                    return response.json();
                })
                .then(data => {
                    checkbox.checked = isDone === 1;
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkbox.checked = !checkbox.checked;
                });
        }

        function showDeleteModal(url) {
            if (confirm("Apakah Anda yakin ingin menghapus todo ini?")) {
                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error("Gagal hapus");
                        location.reload();
                    })
                    .catch(error => {
                        alert("Error: " + error.message);
                    });
            }
        }
    </script>
</x-app-layout>