<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommentPosted extends Mailable
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
        $subject = "Comment was posted on: {$this->comment->commentable->title}";

        return $this->subject($subject)
            // first example with full path
            // ->attach(
            //     storage_path('app/public') . '/' . $this->comment->user->image->path,
            //     [
            //         'as' => 'profile_pic.jpg',
            //         'mime' => 'image/jpeg'
            //     ]
            // )
            // second example using stage disk
            // ->attachFromStorage($this->comment->user->image->path, 'profile_pic.jpg')
            // ->attachFromStorageDisk('public', $this->comment->user->image->path, 'profile_pic.jpg')
            // ->attachData(Storage::get($this->comment->user->image->path), 'profile_pic.jpg', [
            //     'mime' => 'image/jpg'
            // ])
            ->view('emails.posts.commented');
    }
}
