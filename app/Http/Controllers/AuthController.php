<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected function formatUserData($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function emailVerification(Request $request)
    {
        $validator = Validator::make($request->only('email'), ['email' => 'required|email']);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'request' => $request->only('email'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validator = Validator::make($request->all(), ['email' => 'exists:users,email']);
        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => "The email given is not registered."
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        return response()->json(null, Response::HTTP_OK);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = auth('api')->user();
        $data = $this->formatUserData($user);

        return $this->respondWithToken($token, $data);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = JWTAuth::fromUser($user);
            $data = $this->formatUserData($user);

            return response()->json(['message' => 'Success!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function me()
    {
        try {
            $user = auth('api')->user();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            $data = $this->formatUserData($user);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (JWTException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::getToken();
            $user = auth('api')->user();
            $data = $this->formatUserData($user);
            $newtoken = JWTAuth::refresh($token);

            return $this->respondWithToken($newtoken, $data);
        } catch (JWTException $e) {
            return response()->json(['error' => $e], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }


    protected function respondWithToken($token, $data = ["No aditional Data"], $status = 200)
    {
        return response()->json(array_merge($data, ['access_token' => $token]), $status);
    }
}
