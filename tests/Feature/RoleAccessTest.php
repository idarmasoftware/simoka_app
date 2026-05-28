<?php

use App\Models\Child;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('super admin can access user management', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $response = $this->actingAs($admin)
        ->get(route('users.index'));

    $response->assertStatus(200);
});

test('therapist can access user management', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);

    $response = $this->actingAs($therapist)
        ->get(route('users.index'));

    $response->assertStatus(200);
});

test('therapist can create parent user', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);

    $payload = [
        'name' => 'Orang Tua Baru',
        'email' => 'ortu@gmail.com',
        'username' => 'ortubaru',
        'phone_number' => '0812345',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'orang_tua',
    ];

    $response = $this->actingAs($therapist)
        ->post(route('users.store'), $payload);

    $response->assertRedirect(route('users.index'));

    $created = User::where('username', 'ortubaru')->first();
    expect($created)->not->toBeNull();
    expect($created->role)->toBe('orang_tua');
});

test('therapist cannot create therapist user', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);

    $payload = [
        'name' => 'Terapis Palsu',
        'email' => 'palsu@gmail.com',
        'username' => 'terapispalsu',
        'phone_number' => '08123456',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'terapis', // Trying to create a therapist
    ];

    $response = $this->actingAs($therapist)
        ->post(route('users.store'), $payload);

    // It should fail validation because role must be orang_tua for therapists
    $response->assertSessionHasErrors(['role']);

    $created = User::where('username', 'terapispalsu')->first();
    expect($created)->toBeNull();
});

test('parent cannot access user management', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);

    $response = $this->actingAs($parent)
        ->get(route('users.index'));

    $response->assertStatus(403);
});

test('therapist can access child management', function () {
    $therapist = User::factory()->create(['role' => 'terapis']);

    $response = $this->actingAs($therapist)
        ->get(route('children.index'));

    $response->assertStatus(200);
});

test('parent can access child management and only see their own children', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $otherParent = User::factory()->create(['role' => 'orang_tua']);

    $childOfParent = Child::factory()->create([
        'parent_id' => $parent->id,
        'nama_lengkap' => 'Anak Kandung',
    ]);
    $childOfOther = Child::factory()->create([
        'parent_id' => $otherParent->id,
        'nama_lengkap' => 'Anak Orang Lain',
    ]);

    $response = $this->actingAs($parent)
        ->get(route('children.index'));

    $response->assertStatus(200)
        ->assertSee('Anak Kandung')
        ->assertDontSee('Anak Orang Lain');
});

test('parent cannot access select child page for assessment', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);

    $response = $this->actingAs($parent)
        ->get(route('assessments.select_child'));

    $response->assertStatus(403);
});

test('only super admin can delete child using soft delete', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);

    $child = Child::factory()->create([
        'parent_id' => $parent->id,
        'therapis_id' => $therapist->id,
    ]);

    // Parent cannot delete
    $response = $this->actingAs($parent)->delete(route('children.destroy', $child));
    $response->assertStatus(403);
    expect(Child::find($child->id))->not->toBeNull();

    // Therapist cannot delete
    $response = $this->actingAs($therapist)->delete(route('children.destroy', $child));
    $response->assertStatus(403);
    expect(Child::find($child->id))->not->toBeNull();

    // Admin can delete (soft delete)
    $response = $this->actingAs($admin)->delete(route('children.destroy', $child));
    $response->assertRedirect(route('children.index'));

    // The child is soft deleted: not found via normal query but exists with trashed
    expect(Child::find($child->id))->toBeNull();
    expect(Child::withTrashed()->find($child->id))->not->toBeNull();
});

test('parent and therapist can edit and update child information if authorized', function () {
    $parent = User::factory()->create(['role' => 'orang_tua']);
    $otherParent = User::factory()->create(['role' => 'orang_tua']);
    $therapist = User::factory()->create(['role' => 'terapis']);
    $otherTherapist = User::factory()->create(['role' => 'terapis']);

    $child = Child::factory()->create([
        'parent_id' => $parent->id,
        'therapis_id' => $therapist->id,
        'nama_lengkap' => 'Nama Awal',
    ]);

    // Parent can edit their own child
    $this->actingAs($parent)->get(route('children.edit', $child))->assertStatus(200);
    $response = $this->actingAs($parent)->put(route('children.update', $child), [
        'nama_lengkap' => 'Nama Diubah Ortu',
        'tanggal_lahir' => '2020-01-01',
        'jenis_kelamin' => 'L',
    ]);
    $response->assertRedirect(route('children.index'));
    expect($child->refresh()->nama_lengkap)->toBe('Nama Diubah Ortu');

    // Parent cannot edit other children
    $this->actingAs($otherParent)->get(route('children.edit', $child))->assertStatus(403);
    $this->actingAs($otherParent)->put(route('children.update', $child), [
        'nama_lengkap' => 'Diubah Ilegal',
        'tanggal_lahir' => '2020-01-01',
        'jenis_kelamin' => 'L',
    ])->assertStatus(403);

    // Therapist can edit their assigned child
    $this->actingAs($therapist)->get(route('children.edit', $child))->assertStatus(200);
    $response = $this->actingAs($therapist)->put(route('children.update', $child), [
        'nama_lengkap' => 'Nama Diubah Terapis',
        'tanggal_lahir' => '2020-01-01',
        'jenis_kelamin' => 'L',
        'parent_id' => $parent->id,
    ]);
    $response->assertRedirect(route('children.index'));
    expect($child->refresh()->nama_lengkap)->toBe('Nama Diubah Terapis');

    // Therapist cannot edit unassigned children
    $this->actingAs($otherTherapist)->get(route('children.edit', $child))->assertStatus(403);
    $this->actingAs($otherTherapist)->put(route('children.update', $child), [
        'nama_lengkap' => 'Diubah Ilegal Terapis',
        'tanggal_lahir' => '2020-01-01',
        'jenis_kelamin' => 'L',
        'parent_id' => $parent->id,
    ])->assertStatus(403);
});
