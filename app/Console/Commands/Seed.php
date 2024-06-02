<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed the applications main database tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // logic for looping database tables though Orange hill's iseed commands.
            Artisan::call('iseed task_categories,task_priorities --force');
            
            return Command::SUCCESS;

        } catch (\Throwable $th) {
            // throw $th;

            return Command::FAILURE;
        }
    }
}
