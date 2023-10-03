<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Tutor;
class FeatureClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'featured:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tutor is feature expiry date';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        $tutors = Tutor::where('is_featured_end_date', '<', $currentDate)
            ->pluck('id')
            ->toArray();

        Tutor::whereIn('id', $tutors)
            ->update(['is_featured' => 0]);
       
    }
}
