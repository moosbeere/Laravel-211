<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Path;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatMail;

class Schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic';

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
        $articleCount = Path::whereRaw('`url` GLOB :name', ['name'=>'article/*[0-9]'])->count();
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Mail::send(new StatMail($articleCount, $commentCount));
    }
}
