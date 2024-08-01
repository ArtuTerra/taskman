<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(TaskService $taskService): JsonResponse
    {
        $response = $taskService->allTasks();
        return $response;

    }
    public function listTasksAssigns(TaskService $taskService): JsonResponse
    {
        $response = $taskService->allTasksAndAssigns();
        return $response;
    }
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }
    public function destroy(TaskService $taskService, Task $task)
    {
        $response = $taskService->destroy($task->id);
        return $response;
    }
    public function store(TaskService $taskService, TaskRequest $request): JsonResponse
    {
        $task = $taskService->store($request);
        return $task;
    }
    public function update(TaskService $taskService, UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $response = $taskService->update($request->validated(), $task->id);
        return $response;
    }
}
