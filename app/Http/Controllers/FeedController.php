<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\StatusCodes;
use App\Models\Community;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
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
        /** @var Builder|QueryBuilder $query */
        $query = Post::query()
        ->includeIsLikedAttribute($current_id)
        ->addSelect([
            DB::raw("COALESCE(pv.viewed_count,0) as viewed_count"), 
            DB::raw("@likes_count:=(select count(*) from `likes` where `posts`.`id` = `likes`.`likeable_id` and `likes`.`likeable_type` = 'App\\\\Models\\\\Post' and `likes`.`deleted_at` is null) as `likes_count`"),
            DB::raw("@comments_count:=(select count(*) from `comments` where `posts`.`id` = `comments`.`commentable_id` and `comments`.`commentable_type` = 'App\\\\Models\\\\Post' and `comments`.`deleted_at` is null) as `comments_count`"),
            DB::raw("@views_count:=(select count(*) from `post_views` where `posts`.`id` = `post_views`.`post_id`) as `views_count`"),
        ])
        ->withCount('likes', 'comments', 'views')
        ->leftJoin('post_views as pv', function($join) use ($current_id){
            $join->on('posts.id', '=', 'pv.post_id')->where('pv.viewer_id', $current_id);
        })
        ->with(['videos', 'images', 'author', 'author.profileImage'])
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
            $sortBy = request('sortBy');
            $orderBy = "rating_$sortBy";
            if($sortBy === 'hot')
            {
                $query->addSelect(DB::raw("(@likes_count+@comments_count+0E0)/(now()-posts.created_at) as rating_$sortBy"));
                // DB::raw("@rating:=get_rating((Select `comments_count`), (Select `likes_count`),(Select `views_count`)) as rating_top")
            }else if($sortBy === 'best')
            {
                $query->addSelect(DB::raw("(@likes_count-@views_count) as rating_$sortBy"));
            }else if($sortBy === 'active')
            {
                $query->addSelect(DB::raw("((@comments_count+0E0)/(@likes_count+1)) as rating_$sortBy"));
            }else if($sortBy === 'top')
            {
                $sortBy = 'likes_count';
            }else //* if sortBy = new  or anything else
            { 
                $orderBy = 'created_at';
            }
            // $currentProfilePosts = $query->clone()->addSelect(DB::raw('1 as sortKey'))->where('author_id', $current_id)->where('pv.viewed_count', 0)->orderByRaw('sortKey, created_at');
            // $query->orderByRaw("sortKey, rating");
            $communitiesPosts = $query->clone()->addSelect(DB::raw('2 as sortKey'))->where('pageable_type', 'App\Models\Community');
            $followingsPosts = $query->clone()->addSelect(DB::raw('3 as sortKey'))->whereIn('author_id', Profile::current()->followings()->select('profiles_followers.profile_id'));
            //! after this the query will be as big as 4kb of text :((
            $posts = $followingsPosts->union($communitiesPosts)->orderByRaw("sortKey, $orderBy desc");
        }
        
        $posts = $posts
            ->limit(10)
            ->skip(request('skip') ?: 0)
            ->get()
            ->each(function (Post $post) use($current_id) { 
                if($post->pageable_type === Community::morphClass())
                {
                    $post->setRelation('pageable', $post->pageable()->with('iconImage')->first());
                }else if($post->pageable_type === Profile::morphClass()){
                    $post->setRelation('pageable', $post->pageable()->with('profileImage')->first());
                }
                $post->setRelation('comments', tap($post->comments()
                            ->select([
                                'comments.*',
                                DB::raw("(select exists(select * from likes where likes.likeable_id=comments.id and likes.likeable_type='App\\\\Models\\\\Comment' and likes.liker_id=$current_id)) as is_liked")
                            ])
                            ->withCount(['likes', 'replies'])
                            ->with(['commentor', 'commentor.profileImage'])
                            ->take(5)
                            ->get())
                            ->each(function($comment){
                                $comment->setRelation('replies', $comment->replies()->with(['commentor', 'commentor.profileImage'])->withCount(['likes', 'replies'])->limit(5)->get());
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
