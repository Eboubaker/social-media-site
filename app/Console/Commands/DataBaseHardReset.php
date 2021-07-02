<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DataBaseHardReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hard reset database';

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
        // DB::beginTransaction();
        // try {
        //     User::query()->treeForceDelete();
        //     DB::commit();
        // }catch(\Throwable $e)
        // {
        //     report($e);
        //     echo $e->getMessage() . "\n";
        // }
        // $this->call("db:wipe");
        $db = config('database.connections.mysql.database');
        DB::unprepared("drop database if exists $db;create database $db;use $db;");
        $this->call("migrate", ['--seed' => true]);
    }
}
