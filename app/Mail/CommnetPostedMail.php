<?php

namespace App\Mail;

use App\Models\Comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CommnetPostedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comments $comment)
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
        $subject = "Comment was posted on your {$this->comment->commentable->title} blog post";
        if($this->comment->user->image) {
            return $this
                //            ->attach(
                //           storage_path('app/public') . '/' . $this->comment->user->image->path ?? '',
                //           [
                //               'as' => 'profile_picture.jpeg',
                //               'mime' => 'image/jpeg'
                //           ]
                //        )
//                ->attachFromStorage($this->comment->user->image->path, 'profile_pic.jpeg', ['mime' => 'image/jpeg'])
//                ->attachFromStorageDisk('public' ,$this->comment->user->image->path, 'profile_pic.jpeg', ['mime' => 'image/jpeg'])
                ->attachData(Storage::get($this->comment->user->image->path) , 'profile_image_from_data.jpeg',[
                    'mime' => 'image/jpeg'
                 ])
                ->subject($subject)
                ->from('info@laravel.test', 'info')
                ->view('emails.posts.commented');
        }else{
            return $this
                ->subject($subject)
                ->from('info@laravel.test', 'info')
                ->view('emails.posts.commented');
        }
    }
}
