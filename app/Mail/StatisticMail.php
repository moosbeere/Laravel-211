<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatisticMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $articleCount;
    protected $commentCount;
    public function __construct($articleCount, $commentCount)
    {
        $this->articleCount = $articleCount;
        $this->commentCount = $commentCount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('moosbeere_O@mail.ru')
                    ->to('moosbeere_O@mail.ru')
                    ->with([
                        'articlecount'=>$this->articleCount,
                        'commentcount' => $this->commentCount
                        ])
                    ->view('mail.stat');
    }
}
