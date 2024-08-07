<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks()
    {
        $tasks = Task::all();
        return $tasks;
    }
    public function getAllTasksAndAssigns()
    {
        $tasks = Task::with('assignedUsers')->get();
        return $tasks;
    }
    public function deleteTask(int $taskId)
    {
        $success = !!Task::destroy($taskId);
        return $success;
    }
    public function createTask(Task $TaskDetails)
    {
        $task = Task::create($TaskDetails->toArray());
        return $task;
    }
    public function updateTask(array $newDetails, int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->update($newDetails);
        return $task;
    }
}
