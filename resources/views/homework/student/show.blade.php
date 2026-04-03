@extends('layouts.homework')

@section('title', $homework->title)
@section('header', 'Submit Homework')

@section('content')
<div class="max-w-3xl">
    <!-- Homework Info -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">{{ $homework->title }}</h3>
            <p class="mt-2 text-gray-600 whitespace-pre-wrap">{{ $homework->description }}</p>
        </div>
        <div class="p-4 bg-gray-50 flex gap-6 text-sm text-gray-600">
            <span><strong>Due Date:</strong> {{ $homework->due_date ? $homework->due_date->format('M d, Y H:i') : 'No due date' }}</span>
            <span><strong>Max Score:</strong> {{ $homework->max_score }}</span>
        </div>
    </div>

    @if($submission)
        <!-- Already Submitted -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Your Submission</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Submitted At</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : '-' }}</p>
                </div>

                @if($submission->content)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Your Answer</label>
                        <div class="mt-1 p-4 bg-gray-50 rounded-lg text-sm text-gray-900 whitespace-pre-wrap">{{ $submission->content }}</div>
                    </div>
                @endif

                @if($submission->hasAttachment())
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Your Attachment</label>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <span class="text-sm text-gray-900">{{ $submission->file_name }}</span>
                            <a href="{{ route('submissions.download', $submission) }}" class="ml-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">Download</a>
                        </div>
                    </div>
                @endif

                @if($submission->isGraded())
                    <div class="border-t pt-4 mt-4">
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-indigo-900">Grade Result</h4>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-gray-600">Score</span>
                                    <p class="text-lg font-bold {{ $submission->score >= ($homework->max_score * 0.6) ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $submission->score }} / {{ $homework->max_score }}
                                    </p>
                                </div>
                                @if($submission->feedback)
                                    <div>
                                        <span class="text-xs text-gray-600">Feedback</span>
                                        <p class="text-sm text-gray-800">{{ $submission->feedback }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">Your submission is pending grading. Check back later for results.</p>
                    </div>
                @endif

                <div class="pt-4">
                    <a href="{{ route('homeworks.student.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Back to Homework List
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Submit Form -->
        @if($homework->isOverdue())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-red-800 font-medium">⚠️ This homework is overdue. You can still submit, but it may be marked as late.</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Submit Your Answer</h3>
            </div>
            <form action="{{ route('submissions.store', $homework) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Your Answer (Optional)</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Type your answer here...">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">Attachment (Optional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition cursor-pointer" onclick="document.getElementById('attachment').click()">
                        <div class="space-y-1 text-center" id="upload-placeholder">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="font-medium text-indigo-600">Click to upload</span>
                            </div>
                            <p class="text-xs text-gray-500">PDF, Word, Images, Videos up to 10MB</p>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="image-preview" class="hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-h-48 rounded-lg shadow-md">
                            <p id="preview-filename" class="mt-2 text-sm text-gray-600"></p>
                        </div>
                        
                        <!-- File Preview (non-image) -->
                        <div id="file-preview" class="hidden">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p id="file-filename" class="mt-2 text-sm text-gray-600 font-medium"></p>
                        </div>
                    </div>
                    <input id="attachment" name="attachment" type="file" class="hidden" accept="image/*,.pdf,.doc,.docx,.mp4,.mov,.avi">
                    
                    <!-- Remove button -->
                    <button type="button" id="remove-file" class="hidden mt-2 text-sm text-red-600 hover:text-red-800 font-medium" onclick="removeFile()">
                        ✕ Remove file
                    </button>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Submit Homework
                    </button>
                    <a href="{{ route('homeworks.student.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    @endif
</div>

<script>
    document.getElementById('attachment').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const imagePreview = document.getElementById('image-preview');
        const filePreview = document.getElementById('file-preview');
        const removeBtn = document.getElementById('remove-file');
        
        uploadPlaceholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        
        // Check if it's an image
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-filename').textContent = file.name;
                imagePreview.classList.remove('hidden');
                filePreview.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            // Show file icon for non-images
            document.getElementById('file-filename').textContent = file.name;
            filePreview.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        }
    });
    
    function removeFile() {
        document.getElementById('attachment').value = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('file-preview').classList.add('hidden');
        document.getElementById('remove-file').classList.add('hidden');
    }
</script>
@endsection
