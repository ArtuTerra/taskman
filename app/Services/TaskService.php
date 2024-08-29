<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function allTasks()
    {
        return $this->taskRepository->getAllTasks();
    }

    public function allTasksAndAssigns()
    {
        return $this->taskRepository->getAllTasksAndAssigns();
    }

    public function show(Task $task): Task
    {
        return $this->taskRepository->showTask($task);
    }

    public function destroy(Task $task): bool
    {
        return $this->taskRepository->deleteTask($task);
    }

    public function store(array $taskData): Task
    {
        $taskDetails = new Task([
            'title' => $taskData['title'],
            'description' => $taskData['description'] ?? "",
            'completed' => false,
            'creator_id' => auth('api')->id(),
        ]);

        $task = $this->taskRepository->createTask($taskDetails);

        return $task;
    }

    public function update(array $request, Task $task)
    {
        $task = $this->taskRepository->updateTask($request, $task);

        return $task;
    }
}
