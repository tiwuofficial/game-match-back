<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (! $token = Auth::attempt(['id' => $request->input('id'), 'password' => $request->input('password')])) {
            return response()->json(['error' => 'Unauthorized', 'id' => $request->input('id'), 'password' => $request->input('password')], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        User::create([
            'id' => $request->input('id'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
            'introduction' => $request->input('introduction'),
        ]);
        $token = Auth::attempt(['id' => $request->input('id'), 'password' => $request->input('password')]);
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function users()
    {
        $users = User::get();
        $result = [];
        Log::info($users);
        foreach ($users as $user) {
            $result[] = [
                'id' => $user->id,
                'introduction' => $user->introduction,
            ];
        }
        return response()->json($result);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}