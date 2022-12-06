<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatisticMail;
use App\Models\Comment;

class SendStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendStat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $articleCount = Schedule::whereRaw('`path` GLOB :name', ['name'=>'article/show/*[0-9]'])->count();
        // Log::alert($articleCount);
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Mail::send(new StatisticMail($articleCount, $commentCount));
    }
}
