<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MoveLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:moveLogFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move log files on s3 bucket';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesystem = config('filesystems.private');
        $localDisk = Storage::disk('log'); //getting “log” disk instance
        $localFiles = $localDisk->allFiles('logs'); // getting all log files in from location “storage/logs”
        $cloudDisk = Storage::disk($filesystem); //getting instance of “s3” disk
        $pathPrefix = 'Backup';  // setting target path for log files.
        foreach ($localFiles as $file) {
            $contents = $localDisk->get($file);
            $cloudLocation = $pathPrefix . $file;
            $cloudDisk->put($cloudLocation, $contents);
            $localDisk->delete($file);
        } // moving log files into s3 bucket.
    }
}
