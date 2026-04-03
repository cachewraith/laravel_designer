@extends('layouts.cms')

@section('title', 'Edit Section')
@section('header', 'Edit Section')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl">
    <form action="{{ route('sections.update', $section) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (optional)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $section->slug) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="leave empty to auto-generate">
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
            <select name="type" id="type" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="content" {{ old('type', $section->type) == 'content' ? 'selected' : '' }}>Content</option>
                <option value="hero" {{ old('type', $section->type) == 'hero' ? 'selected' : '' }}>Hero</option>
                <option value="about" {{ old('type', $section->type) == 'about' ? 'selected' : '' }}>About</option>
                <option value="services" {{ old('type', $section->type) == 'services' ? 'selected' : '' }}>Services</option>
                <option value="contact" {{ old('type', $section->type) == 'contact' ? 'selected' : '' }}>Contact</option>
            </select>
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <textarea name="content" id="content" rows="8"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('content', $section->content) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <input type="number" name="order" id="order" value="{{ old('order', $section->order) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex items-center pt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                Update Section
            </button>
            <a href="{{ route('sections.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
