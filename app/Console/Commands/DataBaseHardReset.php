<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        User::all()->forceDelete();
        $this->call("db:wipe");
        $this->call("migrate");
        $this->call("db:seed", ['class' => 'FullSeeds']);
    }
}
