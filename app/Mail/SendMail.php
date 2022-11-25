<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\Comment;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $article;
    protected $comment;

    public function __construct(Article $article, Comment $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
                    ->to('moosbeere_O@mail.ru')
                    ->with(['comment'=>$this->comment, 'article'=>$this->article])
                    ->view('mail.send');
    }
}
