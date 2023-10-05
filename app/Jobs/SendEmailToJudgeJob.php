<?php

namespace App\Jobs;

use App\Mail\SendEmailToJudge;
use App\Models\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailToJudgeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $judge;
    
    public function __construct($judge)
    {
        $this->judge = $judge;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contest = Contest::find($this->judge->contest_id);
        Mail::to($this->judge->email)->send(new SendEmailToJudge($this->judge, $contest));
    }
}
