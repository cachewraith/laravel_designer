<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    // Student: Submit homework
    public function store(Request $request, Homework $homework)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // max 10MB
        ]);

        $studentId = auth()->id() ?? 1;

        // Check if already submitted
        $existingSubmission = Submission::where('homework_id', $homework->id)
            ->where('student_id', $studentId)
            ->first();

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this homework!');
        }

        $submissionData = [
            'homework_id' => $homework->id,
            'student_id' => $studentId,
            'content' => $validated['content'] ?? null,
            'submitted_at' => now(),
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('submissions', 'public');

            $submissionData['file_path'] = $path;
            $submissionData['file_name'] = $file->getClientOriginalName();
            $submissionData['file_type'] = $file->getClientMimeType();
        }

        Submission::create($submissionData);

        return redirect()->route('homeworks.student.index')->with('success', 'Homework submitted successfully!');
    }

    // Teacher: Show submission details
    public function show(Submission $submission)
    {
        $submission->load(['student', 'homework']);
        return view('homework.submissions.show', compact('submission'));
    }

    // Teacher: Grade submission
    public function grade(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . $submission->homework->max_score,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'graded_at' => now(),
        ]);

        return redirect()->route('homeworks.show', $submission->homework_id)->with('success', 'Submission graded successfully!');
    }

    // Download attachment
    public function download(Submission $submission)
    {
        if (!$submission->hasAttachment()) {
            abort(404, 'No attachment found');
        }

        return Storage::disk('public')->download($submission->file_path, $submission->file_name);
    }
}
