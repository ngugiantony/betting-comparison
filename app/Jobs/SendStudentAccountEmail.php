<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAccountCreated;

class SendStudentAccountEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $guardian_email;
    public $password;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $guardian_email, string $password)
    {
        $this->user = $user;
        $this->guardian_email = $guardian_email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        // Send the email
        Mail::to($this->guardian_email)->send(new StudentAccountCreated($this->user, $this->password));
    }

}
