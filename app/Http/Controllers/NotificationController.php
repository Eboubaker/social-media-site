<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInternalServerErrorException;
use App\Http\Resources\NotificationResource;
use App\Http\StatusCodes;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function unread(Request $request)
    {
        return NotificationResource::collection(Profile::current()->unreadNotifications()->whereNotIn('id', $request->get('exclude', []))->get());
    }

    public function read(Request $request)
    {
        if ($result = Profile::current_id()) {
            $ids = $request->get('ids');
            $result = DB::table('notifications')
                ->where('notifiable_type', 'App\Models\Profile')
                ->where('notifiable_id', Profile::current_id())
                ->whereIn('id', $ids)
                ->update([
                    "read_at" => now()
                ]);
        }
        return $result ? response(status:StatusCodes::HTTP_OK) : new HttpInternalServerErrorException;
    }


    public function turnOnPostNotifications(Request $request, Post $post)
    {
        DB::table('posts_notifications_list')->insert(
            array_merge(
                $post->getMorphConstraints('notifiable'),
                ["profile_id" => Profile::current_id()]
            )
        );
    }
}
