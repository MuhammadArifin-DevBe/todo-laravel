<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos;


        return view('daftar-todo')->with([
            'nama' => 'orangs',
            'todos' => $todos
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->all();
        $name = $data['name'];
        $description = $data['description'] ?? null;

        $todo = Todo::create([
            'name' => $name,
            'description' => $description,
            'is_done' => false,
            'user_id' => auth()->id()
        ]);

        return redirect('/todo');
    }

    public function destroy($idTodo)
    {

        $todo = Todo::findOrFail($idTodo);

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }

    public function edit($idTodo)
    {
        $todo = Todo::findOrFail($idTodo);


        return view('edit-todo', ['todo' => $todo]);
    }

    public function update(Request $request, $idTodo)
    {
        $todo = Todo::findOrFail($idTodo);

        $todo->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_done' => $request->is_done
        ]);


        return redirect()->route('todo.index');
    }

    public function updateDone(Request $request, $idTodo)
    {
        $todo = Todo::findOrFail($idTodo);

        $todo->update(
            [
                'is_done' => $request->is_done
            ]
        );

        // mengembalikan response berbentuk json ketika selesai karena method ini
        // digunakan melalui request via javascript
        return response()->json([
            'message' => 'Pembaruan berhasil'
        ]);
    }
}
