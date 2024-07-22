<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Assigned;
use App\Models\Relations;
use App\Models\Users_Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\User;
use PhpParser\Node\Expr\Assign;
use Symfony\Component\HttpFoundation\RequestMatcher\IsJsonRequestMatcher;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ]);

    }

    public function listusers()
    {
        $users = User::with('userCreatedTasks')->get();
        return $users->toArray();
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

    public function assign(Request $request)
    {

        $task = Task::find($request->task_id);

        if ($task === null) {
            return response()->json([
                'status' => '404',
                'message' => 'Task was not found'
            ]);
        }

        // Encontrar o usuário pelo nome
        $user = User::find($request->user_id);

        if ($user === null) {
            return response()->json([
                'status' => '404',
                'message' => 'User was not found'
            ]);
        }

        $users_task = Relations::create([
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User was successfully added to ask',
            'Task' => $users_task->task_id,
            'User' => $users_task->user_id,
            'Assign Id' => $users_task->id,
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
