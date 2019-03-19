<?php

namespace App\Http\Controllers;

use App\Model\Friend;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('id','!=', Auth::user()->id)->get();
        $result = [];
        foreach ($users as $user) {
            $result[] = [
                'user_id' => $user->user_id,
                'introduction' => $user->introduction,
            ];
        }
        return response()->json($result);
    }

    public function me()
    {
        $user = Auth::user();
        return response()->json([
            'userId' => $user->user_id,
            'introduction' => $user->introduction,
        ]);
    }

    public function show($id)
    {
        $user = User::where('user_id', $id)->first();
        $isFriend = false;
        if (Friend::where('to_id', Auth::user()->id)->where('from_id', $user->id)->first()) {
           $isFriend = true;
        }
        $isRequest = false;
        if (\App\Model\Request::where('from_id', Auth::user()->id)->where('to_id', $user->id)->first()) {
            $isRequest = true;
        }
        return response()->json([
            'userId' => $user->user_id,
            'introduction' => $user->introduction,
            'isFriend' => $isFriend,
            'isRequest' => $isRequest
        ]);
    }

    public function update(Request $request)
    {
        Log::info($request);
        $user = Auth::user();
        $user->fill([
            'user_id' => $request->input('user_id'),
            'introduction' => $request->input('introduction'),
        ])->save();
        return response()->json([
            'result' => 'ok'
        ]);
    }
}