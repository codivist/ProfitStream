<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot follow yourself');
        }

        auth()->user()->following()->attach($user);

        return back()->with('success', "You are now following {$user->name}");
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user);

        return back()->with('success', "You have unfollowed {$user->name}");
    }
}
