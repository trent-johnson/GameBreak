<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request, User $user) {
        return view('user.edit', [
            'user' => $user,
            'successes' => null
        ]);
    }

    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'bgg_user' => 'required'
        ]);

        $user->bgg_user = $request->input('bgg_user');

        $user->save();

        $successes = collect(['Profile updated successfully.']);

        return view('user.edit', [
            'user' => $user,
            'successes' => $successes
        ]);
    }
}
