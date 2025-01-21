<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCompletionRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response as Response;

class TaskController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $tasks = Task::orderBy('id', 'desc')->paginate(20)->onEachSide(0);

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(TaskRequest $request): Response
    {
        Task::create($request->only(['title', 'description', 'completed']));

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task): InertiaResponse
    {
        return Inertia::render('Tasks/Edit', [
            'task' => $task,
        ]);
    }

    public function update(TaskRequest $request, Task $task): Response
    {
        $task->update($request->only(['title', 'description', 'completed']));

        return redirect()->route('tasks.index');
    }

    public function completion(TaskCompletionRequest $request, Task $task): Response
    {
        $task->update($request->only(['completed']));

        return redirect()->back();
    }

    public function destroy(Task $task): Response
    {
        $task->delete();

        return redirect()->back();
    }
}
