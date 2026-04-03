@extends('layouts.cms')

@section('title', 'Create Menu')
@section('header', 'Create New Menu')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl">
    <form action="{{ route('menus.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL</label>
            <input type="text" name="url" id="url" value="{{ old('url') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="/about or https://example.com">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                <select name="position" id="position" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="header" {{ old('position') == 'header' ? 'selected' : '' }}>Header</option>
                    <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                </select>
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div>
            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Menu (optional)</label>
            <select name="parent_id" id="parent_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">— No Parent —</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                Create Menu
            </button>
            <a href="{{ route('menus.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
