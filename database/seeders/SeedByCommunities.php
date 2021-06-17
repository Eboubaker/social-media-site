<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Storage;

class SeedByCommunities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this
        ->call(CommunityPermissionsSeeder::class)
        ->call(CommunityRolesSeeder::class)
        ->call(UsersSeeder::class)
        ->call(DefaultsSeeder::class)
        ;
        $this->memes();
        $this->arabmemes();
        $this->quotes();
        $this->facts();

        $this->randomLikes();
    }

    private function memes()
    {
        $community = Community::factory()->create([
            'name' => 'memes',
            'owner_id' => $this->profileWithRandomPic(User::random()->id, 'funnydude23')->id,
        ]);
        $community->iconImage()->save(
            Image::extractModelFromFile(Storage::disk('seeds')->path('community_pics_minified/memes_iconImage.jpg'))
        );
        $community->coverImage()->save(
            Image::extractModelFromFile(Storage::disk('seeds')->path('community_pics_minified/memes_coverImage.jpg'))
        );
        $profiles = new Collection();
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Jake_paul');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Nura_ara');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Zak');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Lee');
        $profiles->each(function($profile) use($community){
            CommunityMember::create([
                'profile_id' => $profile->id,
                'community_id' => $community->id,
            ]);
        });
        $cotext = [
            "😂😂",
            "u/".Profile::random()->username,
            "u/".Profile::random()->username,
            "u/".Profile::random()->username,
            "u/".Profile::random()->username,
            "u/".Profile::random()->username,
            "wtf",
            "hahahahahha",
            "hilarious 🤣🤣",
            "i can't breath 😆",
            "noice",
            "i did't understand",
            "boohoo",
            "sheeeeeeeeesh",
        ];
        foreach(Storage::disk('seeds')->files('/english_memes_minified') as $image)
        {
            $name = explode('.', basename($image))[0];
            $title = Str::startsWith($name, 'img') ? null : $name;
            $post = tap(Post::make([
                'title' => $title,
                'author_id' => $profiles->random()->id
            ])
            ->pageable()->associate($community))->save();
            $post->images()->save(Image::extractModelFromFile(Storage::disk('seeds')->path($image)));
        }
    }

    private function quotes()
    {
        $community = Community::factory()->create([
            'name' => 'quotes',
            'owner_id' => $this->profileWithRandomPic(User::random()->id, 'father_of_words1')->id,
        ]);
        $profiles = new Collection();
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Isolda_Robertina');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Maor_Fadil');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Gabriella_Amalbert');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Vilhelmi_Ihar');
        $profiles->each(function($profile) use($community){
            CommunityMember::create([
                'profile_id' => $profile->id,
                'community_id' => $community->id,
            ]);
        });
        foreach(Storage::disk('seeds')->files('/english_quotes_minified') as $image)
        {
            $name = explode('.', basename($image))[0];
            $title = Str::startsWith($name, 'img') ? null : $name;
            $post = tap(Post::make([
                'title' => $title,
                'author_id' => $profiles->random()->id
            ])
            ->pageable()->associate($community))->save();
            $post->images()->save(Image::extractModelFromFile(Storage::disk('seeds')->path($image)));
        }
        $quotes = collect([
            "The journey of a thousand miles begins with one step.",
            "Give me a lever long enough and a fulcrum on which to place it, and I shall move the world.",
            "If you don't know where you are going, any road will get you there.",
            "O, what a tangled web we weave when first we practise to deceive!",
            "It's not what happens to you, but how you react to it that matters.",
            "The only true wisdom is in knowing you know nothing.",
            "He is no fool who gives what he cannot keep to gain what he cannot lose.",
            "Never interrupt your enemy when he is making a mistake.",
            "The greater danger for most of us lies not in setting our aim too high and falling short; but in setting our aim too low, and achieving our mark.",
            "For beautiful eyes, look for the good in others; for beautiful lips, speak only words of kindness; and for poise, walk with the knowledge that you are never alone.",
            "The pessimist complains about the wind; the optimist expects it to change; the realist adjusts the sails.",
            "Yesterday is history, tomorrow is a mystery, today is God's gift, that's why we call it the present.",
            "In every walk with nature one receives far more than he seeks.",
            "We are what our thoughts have made us; so take care about what you think. Words are secondary. Thoughts live; they travel far.",
            "Work like you don't need the money. Love like you've never been hurt. Dance like nobody's watching.",
            "I'd rather regret the things I've done than regret the things I haven't done.",
            "Always be a first-rate version of yourself, instead of a second-rate version of somebody else.",
            "Knowledge is of no value unless you put it into practice.",
            "A tree is known by its fruit; a man by his deeds. A good deed is never lost; he who sows courtesy reaps friendship, and he who plants kindness gathers love.",
            "My father said there were two kinds of people in the world: givers and takers. The takers may eat better, but the givers sleep better.",
            "With pride, there are many curses. With humility, there come many blessings.",
            "We cannot become what we need to be by remaining what we are.",
            "The young man knows the rules, but the old man knows the exceptions.",
            "I will not follow where the path may lead, but I will go where there is no path, and I will leave a trail.",
            "It's better to be a lion for a day than a sheep all your life.",
            "Being entirely honest with oneself is a good exercise.",
            "Set your course by the stars, not by the lights of every passing ship.",
            "Slow and steady wins the race.",
            "It's not what you look at that matters, it's what you see.",
            "The greatest obstacle to discovery is not ignorance - it is the illusion of knowledge.",
            "If you talk to a man in a language he understands, that goes to his head. If you talk to him in his language, that goes to his heart.",
            "Today's mighty oak is just yesterday's nut, that held its ground.",
            "Even if you're on the right track, you'll get run over if you just sit there.",
            "It requires wisdom to understand wisdom: the music is nothing if the audience is deaf.",
            "What happens is not as important as how you react to what happens.",
            "You always have two choices: your commitment versus your fear.",
            "Be happy. It's one way of being wise.",
            "To win without risk is to triumph without glory.",
            "Knowledge comes, but wisdom lingers. It may not be difficult to store up in the mind a vast quantity of facts within a comparatively short time, but the ability to form judgments requires the severe discipline of hard work and the tempering heat of experience and maturity.",
            "As you walk down the fairway of life you must smell the roses, for you only get to play one round.",
            "Never does nature say one thing and wisdom another.",
            "If the world were perfect, it wouldn't be.",
            "You are a product of your environment. So choose the environment that will best develop you toward your objective. Analyze your life in terms of its environment. Are the things around you helping you toward success - or are they holding you back?",
            "Blessed are those who give without remembering and take without forgetting.",
            "The way you see people is the way you treat them, and the way you treat them is what they become.",
            "Always keep an open mind and a compassionate heart.",
            "It is impossible to love and to be wise.",
            "The superior man blames himself. The inferior man blames others.",
            "Experience is not what happens to you; it's what you do with what happens to you.",
            "Start with what is right rather than what is acceptable.",
            "My advice to you is not to inquire why or whither, but just enjoy your ice cream while it's on your plate.",
            "Adopt the pace of nature: her secret is patience.",
            "Wisdom is knowing what to do next; virtue is doing it.",
            "Once you label me you negate me.",
            "Use what talents you possess; the woods would be very silent if no birds sang there except those that sang best.",
            "The smallest deed is better than the greatest intention.",
            "Beware of false knowledge; it is more dangerous than ignorance.",
            "Beware, so long as you live, of judging men by their outward appearance.",
            "If you want a thing done well, do it yourself.",
            "The best way to predict the future is to invent it.",
        ]);
        foreach(range(1, 10) as $i)
        {
            $t = $quotes->random();
            if(strlen($t) > 255)
            {
                $t = ['body' => $t];
            }else{
                $t = ['title' => $t];
            }
            $post = Post::make($t + [
                'author_id' => $profiles->random()->id
            ])
            ->pageable()->associate($community)->save();
        }
    }
    private function facts()
    {
        $community = Community::factory()->create([
            'name' => 'didyouknow',
            'owner_id' => $this->profileWithRandomPic(User::random()->id, 'curious_human')->id,
        ]);
        $profiles = new Collection();
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'the_end_of_the_end');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'curious_cat');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'iwanttoknowmore');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'nerd265');
        $profiles->each(function($profile) use($community){
            CommunityMember::create([
                'profile_id' => $profile->id,
                'community_id' => $community->id,
            ]);
        });
        $facts = collect([
            "11% of people are left handed",
            "August has the highest percentage of births",
            "unless food is mixed with saliva you can't taste it",
            "the average person falls asleep in 7 minutes",
            "a bear has 42 teeth",
            "an ostrich's eye is bigger than its brain",
            "lemons contain more sugar than strawberries",
            "8% of people have an extra rib",
            "85% of plant life is found in the ocean",
            "Ralph Lauren's original name was Ralph Lifshitz",
            "rabbits like licorice",
            "the Hawaiian alphabet has 13 letters",
            "'Topolino' is the name for Mickey Mouse Italy",
            "a lobsters blood is colorless but when exposed to oxygen it turns blue",
            "armadillos have 4 babies at a time and are all the same sex",
            "reindeer like bananas",
            "the longest recorded flight of a chicken was 13 seconds",
            "birds need gravity to swallow",
            "the most commonly used letter in the alphabet is E",
            "the 3 most common languages in the world are Mandarin Chinese, Spanish and English",
            "dreamt is the only word that ends in mt",
            "the first letters of the months July through to November spell JASON",
            "a cat has 32 muscles in each ear",
            "Perth is Australia's windiest city",
            "Elvis's middle name was Aron",
            "goldfish can see both infrared and ultraviolet light",
            "the smallest bones in the human body are found in your ear",
            "cats spend 66% of their life asleep",
            "Switzerland eats the most chocolate equating to 10 kilos per person per year",
            "money is the number one thing that couples argue about",
            "macadamia nuts are toxic to dogs",
            "when lightning strikes it can reach up to 30,000 degrees celsius (54,000 degrees fahrenheit)",
            "spiders are arachnids and not insects",
            "each time you see a full moon you always see the same side",
            "stewardesses is the longest word that is typed with only the left hand",
            "honey is the only natural food which never spoils",
            "M&M's chocolate stands for the initials for its inventors Mars and Murrie",
            "that you burn more calories eating celery than it contains (the more you eat the thinner you become)",
            "the only continent with no active volcanoes is Australia",
            "the longest street in the world is Yonge street in Toronto Canada measuring 1,896 km (1,178 miles)",
            "about 90% of the worlds population kisses",
            "Coca-Cola originally contained cocaine",
            "the Internet was originally called ARPANet (Advanced Research Projects Agency Network) designed by the US department of defense",
            "toilets use 35% of indoor water use",
            "the fortune cookie was invented in San Francisco",
            "Koalas sleep around 18 hours a day",
            "the first Burger King was opened in Florida Miami in 1954",
            "all insects have 6 legs",
            "the croissant was invented in Austria",
            "In eastern Africa you can buy beer brewed from bananas",
            "African Grey Parrots have vocabularies of over 200 words",
            "a giraffe can clean its ears with its 21 inch tongue",
            "Australia was originally called New Holland",
            "'Lonely Planet' for travelers is based in Melbourne Australia",
        ]);
        foreach(range(1, 10) as $i)
        {
            $t = $facts->random();
            if(strlen("Did you know that " . $t) > 255)
            {
                $t = ['title' => 'Did you know..', 'body' => $t];
            }else{
                $t = ['title' => 'Did you know that ' . $t];
            }
            $post = Post::make($t + [
                'author_id' => $profiles->random()->id
            ])
            ->pageable()->associate($community)->save();
        }
    }
    private function arabmemes()
    {
        $community = Community::factory()->create([
            'name' => 'arabmemes',
            'owner_id' => $this->profileWithRandomPic(User::random()->id, 'tarek')->id,
        ]);
        $profiles = new Collection();
        
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Essa_Ayesha');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Assia_Galila');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Husam_Shakil');
        $profiles[] = $this->profileWithRandomPic(User::random()->id, 'Murtaza_Shahira');
        $profiles->each(function($profile) use($community){
            CommunityMember::create([
                'profile_id' => $profile->id,
                'community_id' => $community->id,
            ]);
        });
        foreach(Storage::disk('seeds')->files('/arabic_memes_minified') as $image)
        {
            $name = explode('.', basename($image))[0];
            $title = Str::startsWith($name, 'img') ? null : $name;
            $post = tap(Post::make([
                'title' => $title,
                'author_id' => $profiles->random()->id
            ])
            ->pageable()->associate($community))->save();
            $post->images()->save(Image::extractModelFromFile(Storage::disk('seeds')->path($image)));
        }
    }


    private function profileWithRandomPic($user_id, $username)
    {
        return tap(Profile::factory()->create([
            'username' => $username,
            'user_id' => $user_id,
        ]), function($profile){
            $profile->profileImage()->save(Image::extractModelFromFile(Storage::disk('seeds')->path(collect(Storage::disk('seeds')->files('/english_people_minified'))->random())));
        });
    }


    private function randomLikes()
    {
        $posts = Post::where('pageable_type', 'like', '%Community')->get('id');
        $account = User::first()->id;
        $c = $posts->count()-1;
        $pid = 999;
        $now = now();
        $pq = "INSERT INTO profiles (`id`, `user_id`, `username`) VALUES ";
        $lq = "INSERT INTO likes (`likeable_type`, `likeable_id`, `liker_id`) VALUES ";
        foreach($posts as $n => $post)
        {
            $count = random_int(random_int(300, 600), random_int(600, 3500));
            
            for($i = 0; $i < $count; $i++)
            {
                echo "\r$n/$c $i/$count      ";
                $pq .= "(".++$pid.",$account, 'liker_$pid'),";
                $lq .= "("."'App\\\\Models\\\\Post'".",$post->id,$pid),";
            }
        }
        $pq = substr($pq, 0, strlen($pq)-1) . ";";
        $lq = substr($lq, 0, strlen($lq)-1) . ";";
        echo "\rcommiting transaction..";
        DB::unprepared($pq);
        DB::unprepared($lq);
        echo "\r";
    }
}
