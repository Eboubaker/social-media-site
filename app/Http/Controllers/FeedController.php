<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{

    public function index(Request $request)
    {
        $current_id = Profile::current_id();
        $posts = Post::query()
        ->with(['comments', 'videos', 'images', 'pageable'])
        ->whereHas('images')
        ->whereDoesntHave('views', function($query) use($current_id){
            $query->where('viewer_id', $current_id);
        })
        ->limit(10)
        ->get();
        $views = [];
        foreach($posts as $post)
        {
            $views[] = [
                'viewer_id' => $current_id,
                'post_id' => $post->id
            ];
        }
        DB::table(PostView::tablename())->insert($views);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
