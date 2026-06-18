<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => 'Tenggat Waktu: ' . $this->task->title,
            'deadline' => $this->task->deadline?->format('Y-m-d H:i'),
            'message' => 'Tugas "' . $this->task->title . '" telah mencapai tenggat waktu!',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'title' => 'Tenggat Waktu: ' . $this->task->title,
            'deadline' => $this->task->deadline?->format('Y-m-d H:i'),
            'message' => 'Tugas "' . $this->task->title . '" telah mencapai tenggat waktu!',
        ]);
    }
}
