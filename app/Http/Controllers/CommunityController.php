<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpPermissionException;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'show',
        ]);
    }
    public function create()
    {
        return view('community.create');
    }
    public function show(Community $community)
    {
        return view('community.show', compact('community'));
    }
    public function store(Request $request)
    {
        $community = DB::transaction(function () use ($request) {
            $community = Profile::current()->ownedCommunities()->create($request->all());
            $community->members()->save(CommunityMember::make([
                'profile_id' => Profile::current_id(),
                'role_id' => CommunityRole::OWNER_ROLE_ID,
            ]));
            return $community;
        });
        return redirect($community->url);
    }
    public function edit(Community $community)
    {
        return view('community.edit', compact('community'));
    }
    public function update(Request $request, Community $community)
    {
        if($community->currentIsMember())
        {
            $new = Community::make(request()->all() + $community->attributesToArray());
            $new->isValidOrFail();
            if($new->name !== $community->name)
            {
                if($community->allowsCurrent(config('permissions.can-modify-community-name')))
                {
                    $community->update(['name' => request('name')]);
                }else{
                    goto forbidden;
                }
            }
            if($new->description !== $community->description)
            {
                if($community->allowsCurrent(config('permissions.can-modify-community-description')))
                {
                    $community->update(['description' => request('description')]);
                }else{
                    goto forbidden;
                }
            }
            if(request()->file('iconImage'))
            {
                if($community->allowsCurrent(config('permissions.can-modify-community-icon-image')))
                {
                    // TODO: 
                }else{
                    goto forbidden;
                }
            }
            if(request()->file('coverImage'))
            {
                if($community->allowsCurrent(config('permissions.can-modify-community-cover-image')))
                {
                    // TODO:
                }else{
                    goto forbidden;
                }
            }
            return redirect($community->url);
        }
        forbidden:
            throw new HttpPermissionException;
    }
}
