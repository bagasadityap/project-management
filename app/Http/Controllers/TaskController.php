<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        Task::create($request->all());
        return back();
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }
}

