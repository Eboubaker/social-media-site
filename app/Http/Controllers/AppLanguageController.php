<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AppLanguageController extends Controller
{
    /**
     * set the user locale
     */
    public function update()
    {
        if(in_array(request('locale'), config('app.locales'), true))
        {
            Session::put('locale', request('locale'));
            return back();
        }
        abort(501);
    }
}
