<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
class UpdateAppleSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:apple-secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apple client secret variable
     update in environment file every month';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $value = generateClientSecret();
        putenv("APPLE_CLIENT_SECRET=$value");
        Artisan::call('config:cache');
    }
}
