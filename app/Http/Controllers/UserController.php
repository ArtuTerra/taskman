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

        foreach ($request->user_ids as $user_id) {
            $user = User::find($user_id);

            if ($user === null) {
                return response()->json([
                    'message' => `User with ID $user_id was not found`
                ], 404);
            }

            Relations::firstOrCreate([
                'user_id' => $user_id,
                'task_id' => $task->id,
            ]);

        }

        $taskWithAssigns = $task->load('assignedUsers');

        return response()->json(
            $taskWithAssigns,
        );
    }

    public function removeAssign(Request $request, Task $task)
    {

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        foreach ($request->user_ids as $user_id) {
            $user = User::find($user_id);

            if ($user === null) {
                return response()->json([
                    'message' => `User with ID $user_id was not found`
                ], 404);
            }

            $relationIndex = Relations::where('user_id', $user_id)->where('task_id', $task->id)->firstOrFail();

            if ($relationIndex) {
                $relationIndex->delete();
            }
        }

        $taskWithAssigns = $task->load('assignedUsers');

        return response()->json(
            $taskWithAssigns,
        );

    }
}
