<?php

namespace App\Jobs;


use App\Mail\TeacherCreated;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendTeacherAccountEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $teacher;
    public $password;

    /**
     * Create a new job instance.
     */
    public function __construct(User $teacher, $password)
    {
        $this->teacher = $teacher;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        // Send the email
        Mail::to($this->teacher->email)->send(new TeacherCreated($this->teacher, $this->password));
    }


}
