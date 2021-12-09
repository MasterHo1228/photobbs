<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow', $user);

        if ( ! Auth::user()->isFollowing($user)) {
            Auth::user()->follow($user);
        }

        return redirect()->route('users.show', $user->id)->with('success', '已成功关注该用户！');
    }

    public function destroy(User $user)
    {
        $this->authorize('follow', $user);

        if (Auth::user()->isFollowing($user)) {
            Auth::user()->unfollow($user);
        }

        return redirect()->route('users.show', $user->id)->with('danger', '已取消关注该用户！');
    }
}
