@extends('layouts.homework')

@section('title', 'Edit Homework')
@section('header', 'Edit Homework')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl">
    <form action="{{ route('homeworks.update', $homework) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $homework->title) }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $homework->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                <input type="datetime-local" name="due_date" id="due_date"
                    value="{{ old('due_date', $homework->due_date ? $homework->due_date->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="max_score" class="block text-sm font-medium text-gray-700 mb-2">Max Score</label>
                <input type="number" name="max_score" id="max_score" value="{{ old('max_score', $homework->max_score) }}" required min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $homework->is_active) ? 'checked' : '' }}
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                Update Homework
            </button>
            <a href="{{ route('homeworks.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
