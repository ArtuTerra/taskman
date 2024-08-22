<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = auth('api')->attempt($request->validated())) {
            return response()->json([
                'message' => 'Password is incorrect! Please try again.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = auth('api')->user();

        return $this->respondWithToken($token, $user->toArray(), Response::HTTP_OK);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json(['message' => 'Success!'], Response::HTTP_CREATED);
    }

    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        return response()->json($user->toArray(), Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_NO_CONTENT);
    }

    public function refresh(): JsonResponse
    {
        $user = auth('api')->user();
        $newtoken = auth('api')->refresh();

        return $this->respondWithToken($newtoken, $user->toArray(), Response::HTTP_OK);
    }

    protected function respondWithToken(
        string $token,
        array|null $data = ["No aditional Data"],
        int $status = Response::HTTP_OK
    ): JsonResponse {
        $timeToLive = auth('api')->factory()->getTTL();
        $responseData = array_merge($data, [
            'access_token' => $token,
            'expires_in' => $timeToLive
        ]);
        return response()->json($responseData, $status);
    }
}
