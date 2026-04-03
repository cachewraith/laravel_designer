<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::ordered()->get();
        return view('cms.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('cms.sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sections',
            'content' => 'nullable|string',
            'type' => 'required|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->has('is_active');

        Section::create($validated);

        return redirect()->route('sections.index')->with('success', 'Section created successfully!');
    }

    public function show(Section $section)
    {
        return view('cms.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('cms.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sections,slug,' . $section->id,
            'content' => 'nullable|string',
            'type' => 'required|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->has('is_active');

        $section->update($validated);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully!');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully!');
    }
}
