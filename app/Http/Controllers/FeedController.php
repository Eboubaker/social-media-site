<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $sql = <<<SQL 
        //     select * from `users`
        // SQL;
        // TODO: convert this HUGE query into a text query
        $query = Post::query()
        ->select(['posts.*', 
            DB::raw("COALESCE(pv.viewed_count,0) as viewed_count"), 
            DB::raw("(select exists(select * from likes where likes.likeable_id=posts.id and likes.likeable_type='App\\\\Models\\\\Post' and likes.liker_id=$current_id)) as is_liked"),
            DB::raw("(select count(*) from `likes` where `posts`.`id` = `likes`.`likeable_id` and `likes`.`likeable_type` = 'App\\\\Models\\\\Post' and `likes`.`deleted_at` is null) as `likes_count`"),
            DB::raw("(select count(*) from `comments` where `posts`.`id` = `comments`.`commentable_id` and `comments`.`commentable_type` = 'App\\\\Models\\\\Post' and `comments`.`deleted_at` is null) as `comments_count`"),
            DB::raw("(select count(*) from `post_views` where `posts`.`id` = `post_views`.`post_id`) as `views_count`"),
            DB::raw("get_rating((Select `comments_count`), (Select `likes_count`),(Select `views_count`)) as rating")
        ])
        ->withCount('likes', 'comments', 'views')
        ->leftJoin('post_views as pv', function($join) use ($current_id){
            $join->on('posts.id', '=', 'pv.post_id')->where('pv.viewer_id', $current_id);
        })
        ->with(['videos', 'images', 'pageable', 'author', 'author.profileImage', 'author.account'])
        ;
        

        if($profilePage = ! empty(request('username')))
        {
            $p = DB::table('profiles')->where('username', request('username'))->first('id');
            if(is_null($p->id))
            {
                abort(StatusCodes::HTTP_NOT_FOUND);
            }
            $posts = $query->where('author_id', $p->id)->orderByDesc('created_at');
        }else{
            $currentProfilePosts = $query->clone()->where('author_id', $current_id)->where('pv.viewed_count', 0)->orderByDesc('created_at');
            $query->orderByDesc('rating');
            $communitiesPosts = $query->clone()->where('pageable_type', 'App\Models\Community');
            $followingsPosts = $query->clone()->whereIn('author_id', Profile::current()->followings()->select('profiles_followers.profile_id'));
            // after this the query will be as big as 4kb of text :((
            $posts = $currentProfilePosts->union($followingsPosts)->union($communitiesPosts);
        }
        
        $posts = $posts->skip(request('skip') ?: 0)
            ->limit(10)
            ->get()
            ->each(function (Post $post) use($current_id) { 
                $post->setRelation('comments', tap($post->comments()
                            ->select([
                                'comments.*',
                                DB::raw("(select exists(select * from likes where likes.likeable_id=comments.id and likes.likeable_type='App\\\\Models\\\\Comment' and likes.liker_id=$current_id)) as is_liked")
                            ])
                            ->withCount(['likes', 'replies'])
                            ->take(5)
                            ->get())
                            ->each(function($comment){
                                $comment->setRelation('replies', $comment->replies()->limit(5)->get());
                            }));
            });
        // update view_count in post_views table
        if($posts->count() > 0)
        {
            $query = "INSERT INTO post_views (`post_id`, `viewer_id`) VALUES ";
            $bindings = [];
            $last = $posts->last();
            foreach ($posts as $key => $post) {
                $query .= "(?,?)";
                if($post !== $last)
                    $query .= ",";
                $bindings[] = $post->id;
                $bindings[] = $current_id;
            }
            $query .= " ON DUPLICATE KEY UPDATE viewed_count=viewed_count+1;";
            DB::statement($query, $bindings);
        }
        //send posts as resource
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
