<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Comment;
use App\Models\Stat;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatMail;

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
        $countArticle=Stat::whereRaw('`path` GLOB  :name', ['name'=>'*[0-9]'])->count();
        $countComment=Comment::whereDate('created_at', Carbon::today())->count();
        Mail::send(new StatMail($countArticle, $countComment));
    }
}
