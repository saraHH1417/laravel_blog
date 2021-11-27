<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    // for specifying tries
//    public $tries = 10;
//    // when you have computation or sth else that takes long , you can use $timeout , it is in seconds.
//    public $timeout = 30;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $mail;
    public $user;
    public function __construct(Mailable $mail, User $user)
    {
        $this->mail = $mail;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Redis::throttle('mailtrap')->allow(10)->every(60)->then(function () {
//            // Job logic...
//            Mail::to($this->user)->send($this->mail);
//        }, function () {
//            // Could not obtain lock...
//            // release receives time parameter and  it specifies if job fails in what time repeat it again.
//            return $this->release(10);
//        });

        Mail::to($this->user)->send($this->mail);
    }
}
