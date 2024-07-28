<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{


    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks->values());

    }

    public function listTasksAssigns()
    {
        $tasks = Task::with('assignedUsers')->get();
        return $tasks->toArray();
    }

    public function store(TaskRequest $request)
    {

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
            'creator_id' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'Task' => $task,
            'creator' => User::find(auth()->id()),
        ]);
    }

    public function show($id): JsonResponse
    {

        $task = Task::find($id);

        if ($task === null) {
            return response()->json([
                'status' => '404',
                'message' => "Task id $id does not exist",
                'task' => $task,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'task' => $task,
        ]);

    }

    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $task = Task::find($id);

        if ($task === null) {
            return response()->json([
                'status' => '404',
                'message' => "Task id $id does not exist",
                'task' => $task,
            ]);
        }

        $task->title = $request->title;
        $task->description = $request->description;

        $request->completed === null ? $task->completed = false : $task->completed = $request->completed;

        $task->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task === null) {
            return response()->json([
                'status' => '404',
                'message' => "Task id $id does not exist",
                'task' => $task,
            ]);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
            'task' => $task,
        ]);
    }
}
