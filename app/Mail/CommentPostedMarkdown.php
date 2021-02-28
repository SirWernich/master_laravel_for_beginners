<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// php artisan make:mail CommentPostedMarkdown --markdown=emails.posts.commented-markdown
// publish components:
// php artisan vendor:publish --tag=laravel-mail
class CommentPostedMarkdown extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // breaking change! no import! (making queue fail manually)
        // $post = new BlogPost();
        $subject = "Comment was posted on: {$this->comment->commentable->title}";

        return $this->subject($subject)
            ->markdown('emails.posts.commented-markdown');
    }
}
