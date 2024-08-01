<?php

namespace App\Http\Controllers;

use App\Models\Relations;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function listUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function listUsersAllRelated()
    {
        $users = User::with('assignedTasks')->with('createdTasks')->get();
        $userData = $users->map(function ($user) {
            return $this->userService->formatUserData($user, ['assignedTasks', 'createdTasks']);
        });

        return response()->json($userData);
    }

    public function listUsersA()
    {
        $users = User::with('assignedTasks')->get();
        $userData = $users->map(function ($user) {
            return $this->userService->formatUserData($user, ['assignedTasks']);
        });

        return response()->json($userData);
    }

    public function assign(Request $request, Task $task)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        // $task = Task::find($request->task_id);

        // if ($task === null) {
        //     return response()->json([
        //         'message' => 'Task was not found'
        //     ], 404);
        // }

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
                'task_id' => $task->id,
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
