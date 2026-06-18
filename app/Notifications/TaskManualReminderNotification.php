<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TaskManualReminderNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => 'Pengingat Tugas: ' . $this->task->title,
            'message' => 'Terapis mengingatkan Anda untuk segera melanjutkan tugas ' . $this->task->title . ' untuk anak Anda, ' . $this->task->child->nama_lengkap . '.',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'task_id' => $this->task->id,
            'title' => 'Pengingat Tugas: ' . $this->task->title,
            'message' => 'Terapis mengingatkan Anda untuk segera melanjutkan tugas ' . $this->task->title . ' untuk anak Anda, ' . $this->task->child->nama_lengkap . '.',
        ]);
    }
}
