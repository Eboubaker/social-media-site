<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\StatusCodes;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        Auth::user()->profiles()->create($this->validated($request->all()));
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
        return view('profile.show', compact('profile'));
    }
    public function current()
    {
        return new ProfileResource(Profile::current()->load(['profileImage', 'account']));
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
        $profile->update($this->validated($request->all()));
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
        if (Auth::id() === $profile->user_id) {
            if (Profile::current()->is($profile) && DB::table('profiles')->where('user_id', Auth::id())->count() <= 1) {
                abort(StatusCodes::HTTP_NOT_ACCEPTABLE, "YOU ONLY HAVE ONE PROFILE");
            } else {
                $profile->delete();
                return redirect('/');
            }
        }
        abort(StatusCodes::HTTP_UNAUTHORIZED);
    }


    public function switch(Profile $profile)
    {
        if (Auth::user()->owns($profile)) {
            $profile->update(["active" => true]);
            return redirect('/');
        }
        throw new UnauthorizedException("you don't own this profile");
    }


    public function validated($data)
    {
        $validated = Validator::make($data,
            [
                'username' => ['required', 'min:3', 'max:255', 'regex:/^[A-Za-z][A-Za-z0-9_]+$/', Rule::unique('profiles', 'username')->ignore(Profile::current_id())],
            ],[
                'username.unique' => "Another user is using that username already.",
                'username.regex' => "username may only contain alpha numeric letters and lowdashes(_), no spaces allowed"
            ],[
                
        ])->validate();

        return $validated;
    }
}
