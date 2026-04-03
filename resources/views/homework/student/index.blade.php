@extends('layouts.homework')

@section('title', 'My Homework')
@section('header', 'Student Dashboard - My Homework')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Available Homeworks</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">My Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($homeworks as $homework)
                    @php
                        $isSubmitted = in_array($homework->id, $submissions);
                        $submission = $isSubmitted ? \App\Models\Submission::where('homework_id', $homework->id)->where('student_id', auth()->id() ?? 1)->first() : null;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $homework->title }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($homework->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($homework->due_date)
                                <span class="{{ $homework->isOverdue() && !$isSubmitted ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $homework->due_date->format('M d, Y H:i') }}
                                </span>
                            @else
                                <span class="text-gray-400">No due date</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $homework->max_score }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($submission && $submission->isGraded())
                                <span class="font-semibold {{ $submission->score >= ($homework->max_score * 0.6) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $submission->score }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($isSubmitted)
                                @if($submission->isGraded())
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Graded</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Submitted</span>
                                @endif
                            @else
                                @if($homework->isOverdue())
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pending</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($isSubmitted)
                                <a href="{{ route('homeworks.student.show', $homework) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            @else
                                <a href="{{ route('homeworks.student.show', $homework) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Submit Now</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No homeworks available at the moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
