<?php

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
        ]);

        Project::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Project created successfully!');
    }
}
