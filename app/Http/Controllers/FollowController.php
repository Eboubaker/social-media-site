<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInternalServerErrorException;
use App\Http\StatusCodes;
use App\Models\Profile;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(Request $request, Profile $profile)
    {
        info($profile);
        if(!$profile->followers()->wherePivot('follower_id', Profile::current_id())->exists())
        {
            if($profile->followers()->save(Profile::current()))
            {
                $profile->notify(new NewFollowerNotification(Profile::current_id()));
                return response(status:StatusCodes::HTTP_CREATED);
            }
            return new HttpInternalServerErrorException;
        }
        abort(StatusCodes::HTTP_EXPECTATION_FAILED);
    }

    public function unfollow(Request $request, Profile $profile)
    {
        if($profile->followers()->wherePivot('follower_id', Profile::current_id())->exists())
        {
            return $profile->followers()->wherePivot('follower_id', Profile::current_id())->forceDelete()
            ? response(status:StatusCodes::HTTP_NO_CONTENT)
            : new HttpInternalServerErrorException;
        }
        abort(StatusCodes::HTTP_EXPECTATION_FAILED);
    }
}
