<?php

namespace App\Jobs;

use App\Events\GotMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $message
    ) {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $decodeMessage = json_decode($this->message, true);
        try {
            GotMessage::broadcast([
                'id' => $decodeMessage["id"],
                'user_id' => $decodeMessage["user_id"],
                'text' => $decodeMessage["text"],
                'time' => $decodeMessage["time"],
            ]);
            Log::info('Message sent');
        } catch (\Throwable $th) {
            Log::error('Error sending message: ' . $th->getMessage());
            throw $th;
        }
    }
}
