<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppLanguageController extends Controller
{
    /**
     * set the user locale
     */
    public function update()
    {
        if(in_array(request('locale'), config('app.locales'), true))
        {
            response()->cookie(cookie(cookie('locale', request('locale'))));
        }
        return request()->wantsJson()
                ? response()->json(['success' => true], 201)
                : back();
    }
}
