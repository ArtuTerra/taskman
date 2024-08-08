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
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): JsonResponse
    {
        $response = $this->taskService->allTasks();

        return response()->json($response, Response::HTTP_OK);
    }

    public function listTasksAssigns(): JsonResponse
    {
        $response = $this->taskService->allTasksAndAssigns();

        return response()->json($response, Response::HTTP_OK);
    }

    public function show(Task $task): JsonResponse
    {
        $response = $this->taskService->show($task);

        return response()->json($response, Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->destroy($task);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $response = $this->taskService->store($request->validated());

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $updateData = $request->validated();

        if (empty($updateData)) {
            return response()->json(["message" => "Task data is empty!"], Response::HTTP_BAD_REQUEST);
        }

        $response = $this->taskService->update($updateData, $task);

        return response()->json($response, Response::HTTP_OK);
    }
}
