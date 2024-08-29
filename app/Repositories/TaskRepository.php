<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks(): Collection
    {
        $tasks = Task::all();
        return $tasks;
    }

    public function getAllTasksAndAssigns(): Collection
    {
        $tasks = Task::with('assignedUsers')->get();
        return $tasks;
    }

    public function showTask(Task $task)
    {
        return $task->load("assignedUsers");
    }

    public function deleteTask(Task $task): bool
    {
        $success = !!Task::destroy($task->id);
        return $success;
    }

    public function createTask(Task $TaskDetails): Task
    {
        $task = Task::create($TaskDetails->toArray());
        return $task;
    }

    public function updateTask(array $newDetails, Task $task): Task
    {
        $task->update($newDetails);
        return $task->load("assignedUsers");
    }
}
