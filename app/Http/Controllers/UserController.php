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
                'id' => $user->id,
                'introduction' => $user->introduction,
            ];
        }
        return response()->json($result);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json([
            'id' => $user->id,
            'introduction' => $user->introduction,
        ]);
    }
}