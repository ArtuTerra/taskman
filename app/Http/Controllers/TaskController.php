<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use App\Services\TaskService;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(TaskService $taskService): JsonResponse
    {
        $response = $taskService->allTasks();

        return response()->json($response, Response::HTTP_OK);
    }

    public function listTasksAssigns(TaskService $taskService): JsonResponse
    {
        $response = $taskService->allTasksAndAssigns();

        return response()->json($response, Response::HTTP_OK);
    }

    public function show(TaskService $taskService, Task $task): JsonResponse
    {
        $response = $taskService->show($task);

        return response()->json($response, Response::HTTP_OK);
    }

    public function destroy(TaskService $taskService, Task $task): JsonResponse
    {
        $taskService->destroy($task);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function store(TaskService $taskService, TaskRequest $request): JsonResponse
    {
        $response = $taskService->store($request->validated());

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(TaskService $taskService, UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $updateData = $request->validated();

        if (empty($updateData)) {
            return response()->json(["message" => "Task data is empty!"], Response::HTTP_BAD_REQUEST);
        }

        $response = $taskService->update($updateData, $task);

        return response()->json($response, Response::HTTP_OK);
    }
}
