<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\Api\ImageRequest;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Str;
use App\Http\Resources\ImageResource;
use App\Models\User;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $request->user();

        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        //如果检测到上传的是用户头像，同步更新对应用户的头像
        if ($request->type == 'avatar'){
            $defineUser = User::find($user->id);
            $defineUser->avatar = $image->path;
            $defineUser->save();
        }

        return new ImageResource($image);
    }
}
