<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function update(Request $request)
    {
        return ['token' => $request->user()->singleUseToken()];
    }
}