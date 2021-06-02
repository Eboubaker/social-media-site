<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

class ProfileController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // this profile will be active others will be unactive automatically.
        Auth::user()->profiles()->create($this->validated());
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $profile->update($this->validated);
        return redirect($profile->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        if(Auth::id() === $profile->account->getKey())
        {
            if(Profile::current_id() === $profile->getKey())
            {
                abort(403, "Profile is active");
            }else{
                $profile->delete();
                return redirect('/');
            }
        }
        abort(401, "UnAuthorized");
    }


    public function switch(Profile $profile)
    {
        if(Auth::user()->owns($profile))
        {
            $profile->update(["active" => true]);
            return redirect('/');
        }
        throw new UnauthorizedException("you don't own this profile");
    }

    public function validated()
    {
        $dirty = request()->all();
        $rules = [];
        if(request()->method() === 'POST')
        {
            $rules['username'] = ['required', Rule::unique(Profile::tablename(), 'username'), 'min:3', 'max:255', 'regex:/^[A-Za-z0-9_]+$/'];
        }
        
        return Validator::make($dirty, $rules, [// messages
            'username.regex' => 'username may only contain alpha numeric letters and dashes(_)'
        ], [// custom attributes

        ])->validate();
    }
}
