<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewTaskNotification extends Notification implements ShouldBroadcastNow
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
            'title' => 'Tugas Baru: ' . $this->task->title,
            'message' => 'Terapis telah memberikan tugas baru untuk ' . $this->task->child->nama_lengkap,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'title' => 'Tugas Baru: ' . $this->task->title,
            'message' => 'Terapis telah memberikan tugas baru untuk ' . $this->task->child->nama_lengkap,
        ]);
    }
}
