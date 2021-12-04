<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic,User $user)
    {
        $topics = $topic->with('user', 'category')   // 预加载防止 N+1 问题
                        ->where('category_id', $category->id)
                        ->withOrder($request->order)
                        ->paginate(20);

        $active_users = $user->getActiveUsers();

        return view('topics.index', compact('topics', 'category','active_users'));
    }
}
