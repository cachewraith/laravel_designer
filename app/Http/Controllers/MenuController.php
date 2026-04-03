<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->orderBy('order')
            ->get();
        return view('cms.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->active()->get();
        return view('cms.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Menu::create($validated);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully!');
    }

    public function show(Menu $menu)
    {
        return view('cms.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->active()
            ->get();
        return view('cms.menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menus,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully!');
    }
}
