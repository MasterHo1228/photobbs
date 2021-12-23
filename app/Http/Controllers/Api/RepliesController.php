<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\ReplyQuery;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Reply;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\ReplyRequest;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            abort(404);
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return response(null, 204);
    }

    public function index($topic_id, ReplyQuery $query)
    {
        $replies = $query->where('topic_id',$topic_id)->paginate();

        return ReplyResource::collection($replies);
    }

    public function userIndex($user_id, ReplyQuery $query)
    {
        $replies = $query->where('user_id',$user_id)->paginate();

        return ReplyResource::collection($replies);
    }
}
