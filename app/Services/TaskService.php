<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Task;
use App\Repositories\TaskRepository;


class TaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function allTasks()
    {
        $tasks = $this->taskRepository->getAllTasks();
        if (empty($tasks)) {
            return response()->json([], Response::HTTP_OK);
        }

        return response()->json($tasks, Response::HTTP_OK);
    }
    public function allTasksAndAssigns()
    {
        $tasks = $this->taskRepository->getAllTasksAndAssigns();

        if (empty($tasks)) {
            return response()->json([], Response::HTTP_OK);
        }

        return response()->json($tasks, Response::HTTP_OK);
    }
    public function destroy(int $taskId)
    {
        $this->taskRepository->deleteTask($taskId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
    public function store(TaskRequest $taskData): JsonResponse
    {
        $taskDetails = new Task([
            'title' => $taskData->title,
            'description' => $taskData->description ?? "",
            'completed' => false,
            'creator_id' => auth('api')->id(),
        ]);

        $task = $this->taskRepository->createTask($taskDetails);

        return response()->json($task, Response::HTTP_CREATED);
    }
    public function update(array $request, int $taskId)
    {
        if (empty($request)) {
            return response()->json(["message" => "Task data is empty!"], Response::HTTP_BAD_REQUEST);
        }

        $task = $this->taskRepository->updateTask($request, $taskId);

        return response()->json($task, Response::HTTP_OK);
    }
}
