<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use DB;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function wapiIndex(Request $request)
    {
        return $this->index($request);
    }
    public function feedForVisitor(Request $request)
    {
        return html()->span("طنح روح دير ")->attribute('dir', 'rtl')->addChild(html()->a('/login', 'login'))->toHtml();
    }
    public function feedForProfile(Request $request, Profile $profile)
    {
        return (new FeedController)->index($request);
    }
    public function index(Request $request)
    {
        $current_id = Profile::current_id();
        $query = Post::query()
        ->with(['videos', 'images', 'pageable', 'author', 'author.profileImage', 'author.account'])
        ->whereHas('images')
        ->withCount(['likes', 'views', 'comments'])
        // ->whereDoesntHave('views', fn ($q) =>$q->where('viewer_id', $current_id))// where user didnt view the post before
        ->orderByDesc('likes_count')
        ->orderBy('created_at', 'desc');
        $profilePosts = $query->clone();


        $profilePosts->where('author_id', $current_id);
        $feedPosts = $query->clone();
        
        // ->where('pageable_type', 'App\Models\Community')
        // ->whereIn('pageable_id', Profile::current()->joinedCommunities()->select('communities.id'))
        
        
        $posts = $profilePosts->union($feedPosts)
        ->limit(10)
        ->get();
        // $views = [];
        // foreach ($posts as $post) {
        //     $views[] = [
        //         'viewer_id' => $current_id,
        //         'post_id' => $post->id
        //     ];
        // }
        // DB::table(PostView::tablename())->insert($views);
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
