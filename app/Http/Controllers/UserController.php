<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($data);

        return response()->json($user);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($user->id !== auth()->id()) {
            return response()->json(['error' => 'Not authorized.'],403);
        }

        $user->update($data);

        return response()->json();
    }
}
