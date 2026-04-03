@extends('layouts.homework')

@section('title', 'Grade Submission')
@section('header', 'Review & Grade Submission')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Submission Details -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Submission Details</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Student</label>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->student->name ?? 'Unknown' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Homework</label>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->homework->title }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Submitted At</label>
                <p class="mt-1 text-sm text-gray-900">{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Student's Answer</label>
                <div class="mt-1 p-4 bg-gray-50 rounded-lg text-sm text-gray-900 whitespace-pre-wrap">{{ $submission->content ?: 'No written answer' }}</div>
            </div>

            @if($submission->hasAttachment())
                <div>
                    <label class="block text-sm font-medium text-gray-700">Attachment</label>
                    <div class="mt-1 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        <span class="text-sm text-gray-900">{{ $submission->file_name }}</span>
                        <a href="{{ route('submissions.download', $submission) }}" class="ml-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">Download</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Grading Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">{{ $submission->isGraded() ? 'Update Grade' : 'Grade Submission' }}</h3>
        </div>
        <form action="{{ route('submissions.grade', $submission) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="score" class="block text-sm font-medium text-gray-700 mb-2">Score (Max: {{ $submission->homework->max_score }})</label>
                <input type="number" name="score" id="score" value="{{ old('score', $submission->score) }}" required
                    min="0" max="{{ $submission->homework->max_score }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                <textarea name="feedback" id="feedback" rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Provide feedback to the student...">{{ old('feedback', $submission->feedback) }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    {{ $submission->isGraded() ? 'Update Grade' : 'Submit Grade' }}
                </button>
                <a href="{{ route('homeworks.show', $submission->homework) }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    Back to Homework
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
