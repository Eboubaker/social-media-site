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
    public function store()
    {
        $validated = $this->validated();
        $validated['owner_id'] = Profile::current_id();
        $validated['default_role_id'] = CommunityRole::DEFAULT_ROLE_ID;
        $community = DB::transaction(function () use ($validated) {
            $community = Community::create($validated);
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
        info("uppdating communtiy " . $community->name);
        info($member);
        info(Profile::current_id());
        info($community);
        info($member->exists);
        if($member && $member->exists)
        {
            $validated = $this->validated();
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
            info("uppdated communtiy");
            return redirect($community->url);
        }
        forbidden:
            info("failed to updated community ");
        abort(403, "Forbidden");
    }
    public function validated()
    {
        $dirty = request()->all();
        return Validator::make($dirty, [
            'name' => ['required', Rule::unique(Community::tablename(), 'name')->ignore(request('current_name'), 'name'), 'min:2', 'max:255', 'regex:/^[A-Za-z0-9-]+$/'],
            "description" => ['required', 'max:255']
        ], [// messages
            'name.regex' => 'name may only contain alpha numeric letters and dashes(-)'
        ], [// custom attributes

        ])->validate();
    }
}
