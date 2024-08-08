<?php

namespace App\Interfaces;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getAllTasks();

    public function getAllTasksAndAssigns();

    public function showTask(Task $task);

    public function deleteTask(Task $task);

    public function createTask(Task $taskInfo);

    public function updateTask(array $newInfo, Task $task);
}
