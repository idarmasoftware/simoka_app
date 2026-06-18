<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDeadlineNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskDeadlineReminders extends Command
{
    protected $signature = 'app:send-task-deadline-reminders';

    protected $description = 'Send reminders for tasks that are approaching their deadline';

    public function handle()
    {
        $nowStart = Carbon::now()->startOfMinute();
        $nowEnd = Carbon::now()->endOfMinute();
        
        $tasks = Task::with('child.parent')
            ->whereBetween('deadline', [$nowStart, $nowEnd])
            ->whereIn('status', ['pending', 'in_progress']) // Only notify if task is not submitted or completed
            ->get();

        $count = 0;
        foreach ($tasks as $task) {
            if ($task->child && $task->child->parent) {
                $task->child->parent->notify(new TaskDeadlineNotification($task));
                $count++;
            }
        }

        $this->info("Sent {$count} task deadline reminders.");
    }
}
