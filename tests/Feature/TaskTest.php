<?php

use App\Models\Assessment;
use App\Models\Child;
use App\Models\Task;
use App\Models\TaskStep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('therapist can assign a task with steps to an assessment', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create(['therapis_id' => $therapist->id]);
    $assessment = Assessment::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
    ]);

    $payload = [
        'assessment_id' => $assessment->id,
        'title' => 'Terapi Stimulasi Rumah Taktil',
        'description' => 'Lakukan stimulasi taktil berikut secara bertahap.',
        'steps' => [
            'Langkah 1: Menggosok bulu halus ke lengan anak.',
            'Langkah 2: Membiarkan anak meraba spons kasar.',
        ],
    ];

    $response = $this->actingAs($therapist)
        ->post(route('tasks.store'), $payload);

    $response->assertRedirect(route('assessments.show', $assessment));

    $task = Task::first();
    expect($task)->not->toBeNull();
    expect($task->title)->toBe('Terapi Stimulasi Rumah Taktil');
    expect($task->status)->toBe('pending');
    expect($task->steps()->count())->toBe(2);
    expect($task->steps()->where('step_number', 1)->first()->instruction)->toContain('bulu halus');
});

test('parent can upload videos for task steps step-by-step', function () {
    Storage::fake('public');

    $parent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create([
        'parent_id' => $parent->id,
        'therapis_id' => $therapist->id,
    ]);

    $task = Task::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
        'status' => 'pending',
    ]);

    $step1 = TaskStep::factory()->create(['task_id' => $task->id, 'step_number' => 1]);
    $step2 = TaskStep::factory()->create(['task_id' => $task->id, 'step_number' => 2]);

    $videoFile = UploadedFile::fake()->create('step1.mp4', 1024, 'video/mp4');

    // 1. Parent attempts to upload step 2 directly (should fail since step 1 is not approved)
    $response = $this->actingAs($parent)
        ->post(route('tasks.steps.upload', $step2), [
            'video' => $videoFile,
            'notes' => 'Langkah kedua sebelum langkah 1 disetujui.',
        ]);
    $response->assertRedirect(route('tasks.show', $task));
    $response->assertSessionHas('error', 'Langkah ini terkunci. Anda harus menyelesaikan langkah sebelumnya dan mendapatkan persetujuan dari terapis terlebih dahulu.');

    // 2. Parent uploads step 1
    $response = $this->actingAs($parent)
        ->post(route('tasks.steps.upload', $step1), [
            'video' => $videoFile,
            'notes' => 'Anak terlihat senang melakukannya.',
        ]);

    $response->assertRedirect(route('tasks.show', $task));

    $step1->refresh();
    expect($step1->video_path)->not->toBeNull();
    expect($step1->notes)->toBe('Anak terlihat senang melakukannya.');
    expect($step1->status)->toBe('uploaded');

    // Task status should be in_progress since not all steps have videos
    $task->refresh();
    expect($task->status)->toBe('in_progress');

    // 3. Parent still cannot upload step 2 because step 1 is uploaded but not approved
    $response = $this->actingAs($parent)
        ->post(route('tasks.steps.upload', $step2), [
            'video' => $videoFile,
            'notes' => 'Langkah kedua sebelum langkah 1 disetujui.',
        ]);
    $response->assertRedirect(route('tasks.show', $task));
    $response->assertSessionHas('error', 'Langkah ini terkunci. Anda harus menyelesaikan langkah sebelumnya dan mendapatkan persetujuan dari terapis terlebih dahulu.');

    // 4. Therapist approves step 1
    $response = $this->actingAs($therapist)
        ->post(route('tasks.steps.feedback', $step1), [
            'status' => 'approved',
            'feedback' => 'Bagus sekali, teruskan!',
        ]);
    $response->assertRedirect(route('tasks.review', $task));
    $step1->refresh();
    expect($step1->status)->toBe('approved');

    // 5. Parent uploads step 2 (should succeed now)
    $response = $this->actingAs($parent)
        ->post(route('tasks.steps.upload', $step2), [
            'video' => $videoFile,
            'notes' => 'Langkah kedua selesai.',
        ]);

    // Task status should be submitted because all steps now have videos/approved
    $task->refresh();
    expect($task->status)->toBe('submitted');
});

test('therapist can review step and approve it', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create([
        'parent_id' => $parent->id,
        'therapis_id' => $therapist->id,
    ]);

    $task = Task::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
        'status' => 'submitted',
    ]);

    $step1 = TaskStep::factory()->create([
        'task_id' => $task->id,
        'step_number' => 1,
        'video_path' => 'videos/step1.mp4',
        'status' => 'uploaded',
    ]);

    // Therapist reviews step 1 and approves
    $response = $this->actingAs($therapist)
        ->post(route('tasks.steps.feedback', $step1), [
            'status' => 'approved',
            'feedback' => 'Bagus sekali, gerakannya sudah tepat.',
        ]);

    $response->assertRedirect(route('tasks.review', $task));

    $step1->refresh();
    expect($step1->status)->toBe('approved');
    expect($step1->feedback)->toBe('Bagus sekali, gerakannya sudah tepat.');

    // Task is completed since all steps are approved
    $task->refresh();
    expect($task->status)->toBe('completed');
});
