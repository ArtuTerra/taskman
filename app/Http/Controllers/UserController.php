<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AssignRequest;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use App\Models\Relations;
use App\Models\User;
use App\Models\Task;

class UserController extends Controller
{
    public function listUsers(): JsonResponse
    {
        $users = User::all();

        return response()->json($users);
    }

    public function assign(AssignRequest $request, Task $task): JsonResponse
    {
        $requestData = $request->validated();

        foreach ($requestData->user_ids as $user_id) {
            Relations::firstOrCreate([
                'user_id' => $user_id,
                'task_id' => $task->id,
            ]);
        };

        $taskWithAssigns = $task->load('assignedUsers');

        return response()->json($taskWithAssigns);
    }

    public function removeAssign(AssignRequest $request, Task $task): JsonResponse
    {
        $requestData = $request->validated();

        foreach ($requestData->user_ids as $user_id) {
            Relations::where('task_id', $task->id)->where('user_id', $user_id)->delete();
        };

        $taskWithAssigns = $task->load('assignedUsers');

        return response()->json($taskWithAssigns, Response::HTTP_OK);
    }
}
