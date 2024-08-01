<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskRepositoryInterface;
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
    public function store(TaskRequest $taskData)
    {
        $taskDetails = new Task([
            'title' => $taskData->title,
            'description' => $taskData->description,
            'completed' => false,
            'creator_id' => auth('api')->id(),
        ]);

        $success = $this->taskRepository->createTask($taskDetails);

        if ($success) {
            return response()->json([], Response::HTTP_CREATED);
        }
        return response()->json([], Response::HTTP_NOT_FOUND);
    }
    public function update(array $request, int $taskId)
    {
        if (empty($request)) {
            return response()->json(["message" => "Task data is empty!"], Response::HTTP_BAD_REQUEST);
        }

        $this->taskRepository->updateTask($request, $taskId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
