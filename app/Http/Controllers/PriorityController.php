<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::orderBy('level')->withCount('tasks')->get();
        return view('priorities.index', compact('priorities'));
    }

    public function create()
    {
        return view('priorities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:50'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'level' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        try {
            Priority::create($request->only('name', 'color', 'level'));

            return redirect()->route('priorities.index')
                ->with('success', 'Priority created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create priority.');
        }
    }

    public function destroy(Priority $priority)
    {
        try {
            $priority->delete();
            return back()->with('success', 'Priority deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete priority.');
        }
    }
}
