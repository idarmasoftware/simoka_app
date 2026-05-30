<?php

use App\Models\Assessment;
use App\Models\Child;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('therapist can view select child page', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);

    $response = $this->actingAs($therapist)
        ->get(route('assessments.select_child'));

    $response->assertStatus(200)
        ->assertViewIs('assessment.select_child');
});

test('therapist can view ssp assessment form for assigned child', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create(['therapis_id' => $therapist->id]);

    $response = $this->actingAs($therapist)
        ->get(route('assessments.create', $child));

    $response->assertStatus(200)
        ->assertViewIs('assessment.ssp')
        ->assertViewHas('child');
});

test('therapist cannot view ssp assessment form for unassigned child', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);
    $otherTherapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create(['therapis_id' => $otherTherapist->id]);

    $response = $this->actingAs($therapist)
        ->get(route('assessments.create', $child));

    $response->assertStatus(403);
});

test('therapist can submit ssp assessment and see results', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create(['therapis_id' => $therapist->id]);

    // Build assessment questionnaire answers (q1 to q38, all 4s => total 152)
    $payload = [];
    for ($i = 1; $i <= 38; $i++) {
        $payload["q{$i}"] = 4;
    }
    $payload['clinical_notes'] = 'Anak sensitif terhadap suara dan sentuhan.';

    $response = $this->actingAs($therapist)
        ->post(route('assessments.store', $child), $payload);

    // Should redirect to assessment result page
    $assessment = Assessment::first();
    expect($assessment)->not->toBeNull();
    expect($assessment->score)->toBe(152);
    expect($assessment->result_classification)->toBe('Probable Difference');

    $response->assertRedirect(route('assessments.show', $assessment));

    // Assert child medical record was updated
    $child->refresh();
    expect($child->catatan_medis)->toBe('Anak sensitif terhadap suara dan sentuhan.');
});

test('parent can view their child assessment results', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create([
        'parent_id' => $parent->id,
        'therapis_id' => $therapist->id,
    ]);

    $assessment = Assessment::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
        'score' => 60,
        'result_classification' => 'Probable Difference',
    ]);

    $response = $this->actingAs($parent)
        ->get(route('assessments.show', $assessment));

    $response->assertStatus(200)
        ->assertViewIs('assessment.show')
        ->assertViewHas('assessment');
});

test('parent cannot view other children assessment results', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $otherParent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);

    $child = Child::factory()->create([
        'parent_id' => $otherParent->id,
        'therapis_id' => $therapist->id,
    ]);

    $assessment = Assessment::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
    ]);

    $response = $this->actingAs($parent)
        ->get(route('assessments.show', $assessment));

    $response->assertStatus(403);
});

test('therapist can view assessment results page with reusable tasks list', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);
    $child = Child::factory()->create(['therapis_id' => $therapist->id]);
    $assessment = Assessment::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
    ]);

    // Create an existing task by the therapist
    $task = Task::factory()->create([
        'child_id' => $child->id,
        'therapis_id' => $therapist->id,
        'title' => 'Tugas Reusable Unik',
    ]);

    $response = $this->actingAs($therapist)
        ->get(route('assessments.show', $assessment));

    $response->assertStatus(200)
        ->assertViewHas('existingTasks')
        ->assertSee('Tugas Reusable Unik');
});
