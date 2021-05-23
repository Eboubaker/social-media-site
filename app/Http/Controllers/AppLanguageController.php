<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AppLanguageController extends Controller
{
    /**
     * set the user locale
     */
    public function update()
    {
        if(in_array(request('locale'), config('app.locales'), true))
        {
            // using cookie('locale', request('locale')) will encrypt the cookie
            // manually set the cookie
            header("Set-Cookie:locale=".request('locale').";Max-Age=300000;path=/");
            return redirect(url('/'));
        }
        abort(501);
    }


}
