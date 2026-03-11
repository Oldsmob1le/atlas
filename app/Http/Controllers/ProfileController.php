<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function updateSettings(Request $request)
    {
        $request->user()->update([
            'notify_enabled' => $request->boolean('notify_enabled'),
            'notify_time' => $request->input('notify_time', '24h'),
            'notify_repeat' => $request->input('notify_repeat', '1h'),
        ]);

        return response()->json(['status' => 'success']);
    }
}