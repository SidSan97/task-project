<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteTaskLater implements ShouldQueue
{
    use Queueable;

    public $taskId;

    /**
     * Create a new job instance.
     */
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Task::where('id', $this->taskId)->delete();
    }
}
