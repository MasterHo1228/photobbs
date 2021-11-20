<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:280'
        ]);

        Auth::user()->articles()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }

    public function destroy(Article $article){
        $this->authorize('destroy',$article);
        $article->delete();
        session()->flash('success', '文章已被成功删除！');
        return redirect()->back();
    }
}
