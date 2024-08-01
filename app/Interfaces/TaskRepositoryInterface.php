<?php

namespace App\Interfaces;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getAllTasks();
    public function getAllTasksAndAssigns();
    public function deleteTask(int $taskId);
    public function createTask(Task $taskInfo);
    public function updateTask(array $newInfo, int $taskId);
}
