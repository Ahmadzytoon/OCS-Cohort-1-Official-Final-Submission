<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Branch;
use Illuminate\Http\Request;

class AdminSubjectBranchController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();

        return view('admin.subjects-branches', compact('subjects', 'branches'));
    }

    public function storeSubject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
        ]);

        Subject::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Subject added successfully.');
    }

    public function storeBranch(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:branches,name',
        ]);

        Branch::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Branch added successfully.');
    }
}
