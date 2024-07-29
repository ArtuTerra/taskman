<?php

namespace App\Http\Controllers;

use App\Models\Relations;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class UserController extends Controller
{

    protected function formatUserData($user, $relationships = [])
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        foreach ($relationships as $relationship) {
            if ($user->relationLoaded($relationship)) {
                $data[$relationship] = $user->{$relationship}->map(function ($relatedItem) {
                    return $this->formatRelatedItem($relatedItem);
                });
            }
        }

        return $data;
    }

    protected function formatRelatedItem($relatedItem)
    {
        return [
            'id' => $relatedItem->id,
            'title' => $relatedItem->title,
            'description' => $relatedItem->description,
        ];
    }

    public function listUsers()
    {
        $users = User::all();
        $userData = $users->map(function ($user) {
            return $this->formatUserData($user);
        });

        return response()->json($userData);
    }

    public function listUsersA()
    {
        $users = User::with('assignedTasks')->get();
        $userData = $users->map(function ($user) {
            return $this->formatUserData($user, ['assignedTasks']);
        });

        return response()->json($userData);
    }

    public function listUsersC()
    {
        $users = User::with('userCreatedTasks')->get();
        $userData = $users->map(function ($user) {
            return $this->formatUserData($user, ['userCreatedTasks']);
        });

        return response()->json($userData);
    }

    public function listrelations()
    {
        $relations = Relations::all();
        return response()->json($relations->toArray());
    }

    public function assign(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        $task = Task::find($request->task_id);

        if ($task === null) {
            return response()->json([
                'message' => 'Task was not found'
            ], 404);
        }

        $assignedUsers = [];

        foreach ($request->user_ids as $user_id) {
            $user = User::find($user_id);

            if ($user === null) {
                return response()->json([
                    'message' => `User with ID $user_id was not found`
                ], 404);
            }

            $users_task = Relations::create([
                'user_id' => $user_id,
                'task_id' => $request->task_id,
            ]);

            $assignedUsers[] = [
                'task_id' => $users_task->task_id,
                'user_id' => $users_task->user_id,
                'assign_id' => $users_task->id,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Users were successfully added to task',
            'assigned_users' => $assignedUsers,
        ]);
    }
}
