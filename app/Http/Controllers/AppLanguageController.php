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
        $response = response();
        $result = in_array(request('locale'), config('app.locales'), true);
        if($result)
        {
            $response->cookie(['locale', request('locale')]);
        }
        return  request()->wantsJson()
                ? $response->json(['success' => $result], 201)
                : $response->redirectTo(back()->getTargetUrl());
    }


}
