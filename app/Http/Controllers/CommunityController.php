<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpInternalServerErrorException;
use App\Exceptions\HttpPermissionException;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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
    public function show(string $community)
    {
        $community = cache()->remember("community_${community}_data", 30, function () use($community){
            return Community::with(['coverImage', 'iconImage'])->where('name', $community)->first();
        });
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

    public function search(Request $request, string $search)
    {
        $query = DB::table('communities')->where('name', 'like', "%$search%");
        if($request->input('only_joined', false))
        {
            $query->join('communities_members', 'communities.id', '=', 'communities_members.community_id')
                    ->where('communities_members.profile_id', Profile::current_id());
        }
        $query->limit(5);
        return new JsonResponse($query->get(['name'])->map(fn($r)=>$r->name));
    }

    public function update(Request $request, Community $community)
    {
        if($community->currentIsMember())
        {
            $new = Community::make(request()->all() + $community->attributesToArray());
            $new->isValidOrFail();
            if($new->name !== $community->name)
            {
                if($community->allowsCurrent(config('permissions.communities.can-modify-community-name')))
                {
                    $community->update(['name' => request('name')]);
                }else{
                    goto forbidden;
                }
            }
            if($new->description !== $community->description)
            {
                if($community->allowsCurrent(config('permissions.communities.can-modify-community-description')))
                {
                    $community->update(['description' => request('description')]);
                }else{
                    goto forbidden;
                }
            }
            if(request()->file('iconImage'))
            {
                if($community->allowsCurrent(config('permissions.communities.can-modify-community-icon-image')))
                {
                    // TODO: 
                }else{
                    goto forbidden;
                }
            }
            if(request()->file('coverImage'))
            {
                if($community->allowsCurrent(config('permissions.communities.can-modify-community-cover-image')))
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

    public function join(Request $request, Community $community)
    {
        $pid = Profile::currentRelation()->first('id')->id;
        if(DB::table('communities_members')
                ->where('community_id', $community->id)
                ->where('profile_id', $pid)
                ->exists())
        {
            abort(StatusCodes::HTTP_EXPECTATION_FAILED, 'already a member');
        }
        CommunityMember::create([
            'community_id' => $community->id,
            'profile_id' => $pid
        ]);
        return Response::make();
    }
    public function leave(Request $request, Community $community)
    {
        $pid = Profile::currentRelation()->first('id')->id;
        if(is_null($member = DB::table('communities_members')
                ->where('community_id', $community->id)
                ->where('profile_id', $pid)
                ->first('id')))
        {
            abort(StatusCodes::HTTP_EXPECTATION_FAILED, 'not a member');
        }
        if(DB::table('communities_members')->delete($member->id))
        {
            return Response::make(status:StatusCodes::HTTP_NO_CONTENT);;
        }
        throw new HttpInternalServerErrorException;
    }
}
