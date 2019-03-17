<?php

namespace App\Http\Controllers;

use App\Model\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::get();
        $result = [];
        foreach ($users as $user) {
            $result[] = [
                'user_id' => $user->user_id,
                'introduction' => $user->introduction,
            ];
        }
        return response()->json($result);
    }

    public function show($id)
    {
        $user = User::where('user_id', $id)->first();
        return response()->json([
            'user_id' => $user->user_id,
            'introduction' => $user->introduction,
        ]);
    }
}