<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PermissionsController extends Controller
{
    public function permissionsForCommunity(Community $community)
    {
        if( ! is_null($member = $community->currentMember))
        {
            return Response::json($member->role->permissions);
        }else{
            return Response::json($community->visitorRole->permissions);
        }
    }

    public function permissionsList()
    {
        return Response::json(CommunityPermission::all());
    }
}
