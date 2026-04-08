<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::id())
            ->withCount('tasks')
            ->latest()
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:100'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        try {
            Subject::create([
                'user_id' => Auth::id(),
                'name'    => $request->name,
                'color'   => $request->color,
            ]);

            return redirect()->route('subjects.index')
                ->with('success', 'Subject created successfully! 🎨');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create subject.');
        }
    }

    public function destroy(Subject $subject)
    {
        abort_if($subject->user_id !== Auth::id(), 403);

        try {
            $subject->delete();
            return back()->with('success', 'Subject deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete subject.');
        }
    }
}
