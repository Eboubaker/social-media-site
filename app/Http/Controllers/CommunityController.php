<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only([
            'create',
            'update',
            'destroy'
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
    public function update(Community $community)
    {
        $member = $community->currentMember();
        if($member && $member->exists)
        {
            $validated = request()->all();
            Community::make($validated)->isValidOrFail();
            if($validated['name'] !== $community->name)
            {
                if($member->can(config('permissions.can-modify-community-name')))
                {
                    $community->setAttribute('name', $validated['name']);
                }else{
                    goto forbidden;
                }
            }
            if($validated['description'] !== $community->description)
            {
                if($member->can(config('permissions.can-modify-community_description')))
                {
                    $community->setAttribute('description', $validated['description']);
                }else{
                    goto forbidden;
                }
            }
            $community->save();
            return redirect($community->url);
        }
        forbidden:
            abort(403, "Forbidden");
    }
}
