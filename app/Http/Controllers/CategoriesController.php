<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic)
    {
        $topics = $topic->with('user', 'category')   // 预加载防止 N+1 问题
                        ->where('category_id', $category->id)
                        ->withOrder($request->order)
                        ->paginate(20);
        return view('topics.index', compact('topics', 'category'));
    }
}
