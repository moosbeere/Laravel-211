<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $countArticle;
    protected $countComment;
    public function __construct($countArticle,$countComment)
    {
        $this->countComment=$countComment;
        $this->countArticle=$countArticle;
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
                    ->with(['countArticle'=>$this->countArticle, 'countComment'=>$this->countComment])
                    ->view('mail.stat');
    }
}
