<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    // Teacher: List all homeworks
    public function index()
    {
        $homeworks = Homework::withCount('submissions')->latest()->get();
        return view('homework.teacher.index', compact('homeworks'));
    }

    // Teacher: Create homework form
    public function create()
    {
        return view('homework.teacher.create');
    }

    // Teacher: Store homework
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'required|integer|min:1',
        ]);

        $validated['teacher_id'] = auth()->id() ?? 1;
        $validated['is_active'] = true;

        Homework::create($validated);

        return redirect()->route('homeworks.index')->with('success', 'Homework created successfully!');
    }

    // Teacher: Show homework with submissions
    public function show(Homework $homework)
    {
        $submissions = $homework->submissions()->with('student')->latest()->get();
        return view('homework.teacher.show', compact('homework', 'submissions'));
    }

    // Teacher: Edit homework
    public function edit(Homework $homework)
    {
        return view('homework.teacher.edit', compact('homework'));
    }

    // Teacher: Update homework
    public function update(Request $request, Homework $homework)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $homework->update($validated);

        return redirect()->route('homeworks.index')->with('success', 'Homework updated successfully!');
    }

    // Teacher: Delete homework
    public function destroy(Homework $homework)
    {
        $homework->delete();
        return redirect()->route('homeworks.index')->with('success', 'Homework deleted successfully!');
    }

    // Student: List available homeworks
    public function studentIndex()
    {
        $homeworks = Homework::active()->latest()->get();
        $submissions = Submission::where('student_id', auth()->id() ?? 1)
            ->pluck('homework_id')
            ->toArray();

        return view('homework.student.index', compact('homeworks', 'submissions'));
    }

    // Student: View homework and submit
    public function studentShow(Homework $homework)
    {
        $submission = Submission::where('homework_id', $homework->id)
            ->where('student_id', auth()->id() ?? 1)
            ->first();

        return view('homework.student.show', compact('homework', 'submission'));
    }
}
