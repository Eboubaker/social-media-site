<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('feed');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function landing(Request $request)
    {
        if(Auth::user() && Profile::current_id())
        {
            return $this->feedForProfile($request, Profile::current());
        }else{
            return $this->feedForVisitor($request);
        }
    }

    public function feedForVisitor(Request $request)
    {
        return redirect('/login');//html()->span("طنح روح دير ")->attribute('dir', 'rtl')->addChild(html()->a('/login', 'login'))->toHtml();
    }
    public function feedForProfile(Request $request, Profile $profile)
    {
        return view('feed');
    }
}
