<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management (Super Admin & Terapis)
    Route::middleware('role:super_admin,terapis')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Child Management (Super Admin, Terapis, Orang Tua)
    Route::middleware('role:super_admin,terapis,orang_tua')->group(function () {
        Route::resource('children', ChildController::class);
    });

    // Assessments
    Route::middleware('role:super_admin,terapis')->group(function () {
        Route::get('assessments/select-child', [AssessmentController::class, 'selectChild'])->name('assessments.select_child');
        Route::get('assessments/create/{child}', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('assessments/store/{child}', [AssessmentController::class, 'store'])->name('assessments.store');
    });

    Route::middleware('role:super_admin,terapis,orang_tua')->group(function () {
        Route::get('assessments', [AssessmentController::class, 'index'])->name('assessments.index');
        Route::get('assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');
    });

    // Tasks
    Route::middleware('role:super_admin,terapis,orang_tua')->group(function () {
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    });

    Route::middleware('role:super_admin,terapis')->group(function () {
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}/review', [TaskController::class, 'review'])->name('tasks.review');
        Route::post('tasks/steps/{step}/feedback', [TaskController::class, 'updateStepFeedback'])->name('tasks.steps.feedback');
    });

    Route::middleware('role:orang_tua')->group(function () {
        Route::post('tasks/steps/{step}/upload', [TaskController::class, 'uploadStepVideo'])->name('tasks.steps.upload');
    });

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
