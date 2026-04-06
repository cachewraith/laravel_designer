@extends('layouts.homework')

@section('title', $homework->title)
@section('header', 'Homework Details & Submissions')

@section('content')
<!-- Homework Info -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $homework->title }}</h3>
                <p class="mt-2 text-gray-600 whitespace-pre-wrap">{{ $homework->description }}</p>
            </div>
            <div class="text-right">
                @if($homework->is_active)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                @endif
            </div>
        </div>
        <div class="mt-4 flex gap-6 text-sm text-gray-500">
            <span><strong>Due Date:</strong> {{ $homework->due_date ? $homework->due_date->format('M d, Y H:i') : 'No due date' }}</span>
            <span><strong>Max Score:</strong> {{ $homework->max_score }}</span>
            <span><strong>Total Submissions:</strong> {{ $submissions->count() }}</span>
        </div>
    </div>
</div>

<!-- Submissions List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Student Submissions</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $submission->student->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-500">{{ $submission->student->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($submission->isGraded())
                                <span class="font-semibold {{ $submission->score >= ($homework->max_score * 0.6) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $submission->score }} / {{ $homework->max_score }}
                                </span>
                            @else
                                <span class="text-gray-400">Not graded</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($submission->isGraded())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Graded</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('submissions.show', $submission) }}" class="text-indigo-600 hover:text-indigo-900">Review & Grade</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No submissions yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
