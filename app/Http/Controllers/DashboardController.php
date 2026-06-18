<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Child;
use App\Models\Assessment;
use App\Models\Task;
use App\Models\TaskStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        }

        if ($user->isTerapis()) {
            return $this->terapisDashboard($user);
        }

        if ($user->isOrangTua()) {
            return $this->orangTuaDashboard($user);
        }

        return view('dashboard');
    }

    private function superAdminDashboard()
    {
        $totalTerapis = User::where('role', 'terapis')->count();
        $totalOrangTua = User::where('role', 'orang_tua')->count();
        $totalAnak = Child::count();
        $totalAssessment = Assessment::count();

        return view('dashboard', compact(
            'totalTerapis',
            'totalOrangTua',
            'totalAnak',
            'totalAssessment'
        ));
    }

    private function terapisDashboard($user)
    {
        $totalPasien = Child::where('therapis_id', $user->id)->count();
        
        $assessmentPending = Assessment::where('therapis_id', $user->id)
            ->whereDoesntHave('task')
            ->count();
            
        $langkahMenungguReview = TaskStep::whereHas('task', function($q) use ($user) {
            $q->where('therapis_id', $user->id);
        })->where('status', 'uploaded')->count();
        
        $assessmentSelesaiBulanIni = Assessment::where('therapis_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard', compact(
            'totalPasien',
            'assessmentPending',
            'langkahMenungguReview',
            'assessmentSelesaiBulanIni'
        ));
    }

    private function orangTuaDashboard($user)
    {
        $children = $user->children()->with('therapis')->get();
        $anakTerdaftar = $children->count();
        $childIds = $children->pluck('id');
        
        $tugasBerjalan = Task::whereIn('child_id', $childIds)
            ->where('status', 'in_progress')
            ->count();
            
        $langkahPerluDiunggah = TaskStep::whereHas('task', function($q) use ($childIds) {
            $q->whereIn('child_id', $childIds)
              ->whereNotIn('status', ['completed']);
        })->whereIn('status', ['pending', 'rejected'])->count();

        $assessmentTerakhir = Assessment::whereIn('child_id', $childIds)
            ->latest()
            ->first();

        return view('dashboard', compact(
            'anakTerdaftar',
            'tugasBerjalan',
            'langkahPerluDiunggah',
            'assessmentTerakhir',
            'children'
        ));
    }
}
