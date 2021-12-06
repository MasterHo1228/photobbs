<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use App\Models\Link;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->with('user', 'category')   // 预加载防止 N+1 问题
                        ->where('category_id', $category->id)
                        ->withOrder($request->order)
                        ->paginate(20);

        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'category','active_users','links'));
    }
}
