<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Child;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isOrangTua()) {
            $childId = $request->query('child_id');
            $children = $user->children;

            if ($childId) {
                // Ensure parent owns the child
                if (! $user->children()->where('id', $childId)->exists()) {
                    abort(403, 'Anda tidak diizinkan melihat assessment untuk anak ini.');
                }

                $selectedChild = Child::findOrFail($childId);
                $assessments = Assessment::with(['child', 'therapis'])
                    ->where('child_id', $childId)
                    ->latest()
                    ->paginate(10);

                return view('assessment.index', compact('assessments', 'selectedChild', 'children'));
            }

            return view('assessment.index', compact('children'));
        }

        if ($user->isTerapis()) {
            $assessments = Assessment::with('child')
                ->where('therapis_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            // Admin or other role
            $assessments = Assessment::with(['child', 'therapis'])
                ->latest()
                ->paginate(10);
        }

        return view('assessment.index', compact('assessments'));
    }

    /**
     * Show selection list of children to assess.
     */
    public function selectChild()
    {
        $user = Auth::user();

        if ($user->isTerapis()) {
            $children = Child::where('therapis_id', $user->id)->get();
        } else {
            $children = Child::all();
        }

        return view('assessment.select_child', compact('children'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Child $child)
    {
        // Simple security check: therapist can only assess their assigned children
        if (Auth::user()->isTerapis() && $child->therapis_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan melakukan assessment untuk anak ini.');
        }

        return view('assessment.ssp', compact('child'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Child $child)
    {
        if (Auth::user()->isTerapis() && $child->therapis_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan melakukan assessment untuk anak ini.');
        }

        $rules = [];
        for ($i = 1; $i <= 38; $i++) {
            $rules["q{$i}"] = 'required|integer|between:1,5';
        }
        $rules['clinical_notes'] = 'nullable|string';

        $validated = $request->validate($rules);

        // Calculate score
        $answers = [];
        $totalScore = 0;
        for ($i = 1; $i <= 38; $i++) {
            $val = (int) $validated["q{$i}"];
            $answers[$i] = $val;
            $totalScore += $val;
        }

        // Classification
        // 38 questions. Max score = 190, Min score = 38.
        // Higher score = better (Typical Performance). Lower score = difficulty (Definite Difference).
        if ($totalScore >= 155) {
            $classification = 'Typical Performance';
        } elseif ($totalScore >= 142) {
            $classification = 'Probable Difference';
        } else {
            $classification = 'Definite Difference';
        }

        // Store
        $assessment = Assessment::create([
            'child_id' => $child->id,
            'therapis_id' => Auth::id(),
            'answers' => $answers,
            'score' => $totalScore,
            'result_classification' => $classification,
        ]);

        // If clinical notes were added, save it to the child's medical records
        if (! empty($validated['clinical_notes'])) {
            $child->update([
                'catatan_medis' => $validated['clinical_notes'],
            ]);
        }

        return redirect()->route('assessments.show', $assessment)
            ->with('success', 'Assessment berhasil disimpan! Silakan tentukan rekomendasi atau tugas rumah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        $user = Auth::user();

        // Security check
        if ($user->isOrangTua() && ! $user->children()->where('id', $assessment->child_id)->exists()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat assessment ini.');
        }

        $assessment->load(['child', 'therapis', 'task.steps']);

        // Fetch existing tasks for therapists to choose from for reuse
        $existingTasks = collect();
        if ($user->isTerapis()) {
            $existingTasks = Task::where('therapis_id', $user->id)
                ->with('steps')
                ->latest()
                ->get()
                ->unique('title'); // Keep unique by title to avoid duplicates
        }

        return view('assessment.show', compact('assessment', 'existingTasks'));
    }

    /**
     * Compare pre-assessment and post-assessment for a child.
     */
    public function progress(Request $request)
    {
        $user = Auth::user();
        
        $childId = $request->query('child_id');

        // If no child selected, show selection page
        if (!$childId) {
            if ($user->isTerapis()) {
                $children = Child::where('therapis_id', $user->id)->get();
            } elseif ($user->isOrangTua()) {
                $children = $user->children;
            } else {
                $children = Child::all();
            }
            return view('assessment.select_child_progress', compact('children'));
        }

        // Validate access
        if ($user->isOrangTua() && !$user->children()->where('id', $childId)->exists()) {
            abort(403, 'Anda tidak diizinkan melihat progress untuk anak ini.');
        }

        $selectedChild = Child::findOrFail($childId);
        $assessments = Assessment::where('child_id', $childId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($assessments->count() < 2) {
            return redirect()->route('assessments.progress')
                ->with('error', 'Diperlukan minimal 2 assessment (Pre & Post) untuk melihat perbandingan progress.');
        }

        $preAssessment = $assessments->first();
        $postAssessment = $assessments->last();

        return view('assessment.progress', compact('selectedChild', 'preAssessment', 'postAssessment'));
    }
}
