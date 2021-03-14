<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\AccountNotification;
use App\Models\AccountSettings;
use App\Models\BusinessProfile;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Morphs\Postable;
use App\Models\Post;
use App\Models\ProfileImage;
use App\Models\SocialProfile;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TruncateTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncate all tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Db::transaction(function () {
                DB::statement("SET foreign_key_checks=0");
                Account::truncate();
                AccountSettings::truncate();
                AccountNotification::truncate();
                BusinessProfile::truncate();
                SocialProfile::truncate();
                Postable::truncate();
                Comment::truncate();
                Post::truncate();

                // remove files too
                Video::all()->each(function ($m) {
                    $m->delete();
                });
                Image::all()->each(function ($m) {
                    $m->delete();
                });
                ProfileImage::all()->each(function ($m) {
                    $m->delete();
                });

                echo "Database tables truncated successfully";
            });
        }catch (Exception $e)
        {
            DB::statement("SET foreign_key_checks=1");
            throw $e;
        }
        return 0;
    }
}
