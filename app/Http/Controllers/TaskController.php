<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Task;
use App\Models\TaskStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isTerapis()) {
            $tasks = Task::with(['child', 'assessment'])
                ->where('therapis_id', $user->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->isOrangTua()) {
            $childIds = $user->children()->pluck('id');
            $tasks = Task::with(['child', 'therapis'])
                ->whereIn('child_id', $childIds)
                ->latest()
                ->paginate(10);
        } else {
            $tasks = Task::with(['child', 'therapis'])
                ->latest()
                ->paginate(10);
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Store a newly created task in storage (by therapist).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string|max:1000',
        ]);

        $assessment = Assessment::findOrFail($validated['assessment_id']);

        // Check permission
        if (Auth::user()->isTerapis() && $assessment->therapis_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan membuat tugas untuk assessment ini.');
        }

        // Create the task
        $task = Task::create([
            'assessment_id' => $assessment->id,
            'child_id' => $assessment->child_id,
            'therapis_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending', // pending submission from parent
        ]);

        // Create the steps
        foreach ($validated['steps'] as $index => $instruction) {
            TaskStep::create([
                'task_id' => $task->id,
                'step_number' => $index + 1,
                'instruction' => $instruction,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('assessments.show', $assessment)
            ->with('success', 'Tugas dan langkah-langkah berhasil diberikan kepada orang tua!');
    }

    /**
     * Display the specified task detail.
     */
    public function show(Task $task)
    {
        $user = Auth::user();

        // Security check
        if ($user->isOrangTua() && ! $user->children()->where('id', $task->child_id)->exists()) {
            abort(403, 'Anda tidak memiliki hak akses untuk tugas ini.');
        }

        if ($user->isTerapis() && $task->therapis_id !== $user->id) {
            abort(403, 'Anda bukan terapis yang bertanggung jawab atas tugas ini.');
        }

        $task->load(['child', 'therapis', 'steps' => function ($query) {
            $query->orderBy('step_number', 'asc');
        }]);

        // Redirect to review if therapist
        if ($user->isTerapis()) {
            return redirect()->route('tasks.review', $task);
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the review page for the therapist.
     */
    public function review(Task $task)
    {
        $user = Auth::user();

        if (! $user->isTerapis()) {
            abort(403, 'Hanya terapis yang dapat mereview tugas.');
        }

        if ($task->therapis_id !== $user->id) {
            abort(403, 'Anda bukan terapis yang bertanggung jawab atas tugas ini.');
        }

        $task->load(['child', 'steps' => function ($query) {
            $query->orderBy('step_number', 'asc');
        }]);

        return view('tasks.review', compact('task'));
    }

    /**
     * Parent uploads video for a specific step.
     */
    public function uploadStepVideo(Request $request, TaskStep $step)
    {
        $user = Auth::user();
        $task = $step->task;

        if (! $user->isOrangTua() || ! $user->children()->where('id', $task->child_id)->exists()) {
            abort(403, 'Anda tidak memiliki akses untuk mengunggah video tugas ini.');
        }

        // Sequential step enforcement: Parent cannot upload a step if any previous step is not approved.
        if ($step->step_number > 1) {
            $prevStep = TaskStep::where('task_id', $task->id)
                ->where('step_number', $step->step_number - 1)
                ->first();
            if (! $prevStep || $prevStep->status !== 'approved') {
                return redirect()->route('tasks.show', $task)
                    ->with('error', 'Langkah ini terkunci. Anda harus menyelesaikan langkah sebelumnya dan mendapatkan persetujuan dari terapis terlebih dahulu.');
            }
        }

        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,mkv,webm|max:51200', // max 50MB
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            // Delete old video if exists
            if ($step->video_path) {
                Storage::disk('public')->delete($step->video_path);
            }

            // Store new video
            $path = $request->file('video')->store('videos', 'public');

            $step->update([
                'video_path' => $path,
                'notes' => $request->input('notes'),
                'status' => 'uploaded',
            ]);

            // Update Task status
            $totalSteps = $task->steps()->count();
            $uploadedSteps = $task->steps()->whereIn('status', ['uploaded', 'approved', 'rejected'])->count();

            if ($uploadedSteps === $totalSteps) {
                $task->update(['status' => 'submitted']);
            } else {
                $task->update(['status' => 'in_progress']);
            }

            return redirect()->route('tasks.show', $task)
                ->with('success', "Video untuk Langkah {$step->step_number} berhasil diunggah!");
        }

        return redirect()->route('tasks.show', $task)
            ->with('error', 'Gagal mengunggah video. Pastikan file valid dan di bawah 50MB.');
    }

    /**
     * Therapist updates feedback and approves/rejects a step.
     */
    public function updateStepFeedback(Request $request, TaskStep $step)
    {
        $user = Auth::user();
        $task = $step->task;

        if (! $user->isTerapis() || $task->therapis_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mereview tugas ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'feedback' => 'required|string|max:1000',
        ]);

        $step->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'],
        ]);

        // Recalculate parent task status
        $totalSteps = $task->steps()->count();
        $approvedSteps = $task->steps()->where('status', 'approved')->count();

        if ($approvedSteps === $totalSteps) {
            $task->update(['status' => 'completed']);
        } else {
            // If any step is rejected or still uploaded/pending, task is in_progress
            $task->update(['status' => 'in_progress']);
        }

        return redirect()->route('tasks.review', $task)
            ->with('success', "Feedback untuk Langkah {$step->step_number} berhasil disimpan!");
    }
}
