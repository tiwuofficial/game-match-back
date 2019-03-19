<?php

namespace App\Http\Controllers;

use App\Model\Friend;
use App\Model\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{

    public function store(\Illuminate\Http\Request $request)
    {
        Request::create([
            'from_id' => Auth::user()->id,
            'to_id' => User::where('user_id', $request->input('to_id'))->first()->id
        ]);
        return response()->json([
            'result' => 'ok'
        ]);
    }

    public function requests()
    {
        $requests = Request::where('to_id', Auth::user()->id)->with('fromUser')->get();
        $result = [];
        foreach ($requests as $request) {
            $result[] = [
                'id' => $request->id,
                'user_id' => $request->fromUser->user_id,
            ];
        }
        return response()->json($result);
    }

    public function approval(\Illuminate\Http\Request $request)
    {
        $request = Request::where('id', $request->input('id'))->where('to_id', Auth::user()->id)->first();
        Friend::create([
            'from_id' => $request->from_id,
            'to_id' => $request->to_id
        ]);
        Friend::create([
            'from_id' => $request->to_id,
            'to_id' => $request->from_id
        ]);
        $request->delete();
        return response()->json([
            'result' => 'ok'
        ]);
    }

    public function rejection(\Illuminate\Http\Request $request)
    {
        $request = Request::where('id', $request->input('id'))->where('to_id', Auth::user()->id)->first();
        $request->delete();
        return response()->json([
            'result' => 'ok'
        ]);
    }

    public function friends()
    {
        $friends = Friend::where('to_id', Auth::user()->id)->with('fromUser')->get();
        $result = [];
        foreach ($friends as $friend) {
            $result[] = [
                'user_id' => $friend->fromUser->user_id,
            ];
        }
        return response()->json($result);
    }
}