<?php

namespace App\Http\Controllers;

use App\Models\Grammar;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grammars = Grammar::latest()->paginate(10);
        return view('grammars.index', compact('grammars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grammars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $grammar = Grammar::create($request->only('title', 'description'));

        if ($request->has('questions')) {
            foreach ($request->questions as $q) {
                $grammar->questions()->create([
                    'type' => $q['type'],
                    'question' => $q['question'],
                    'options' => array_map('trim', explode(',', $q['options'])),
                    'correct_answer' => $q['correct_answer'],
                ]);
            }
        }

        return redirect()->route('grammars.index')->with('success', 'Grammar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grammar $grammar)
    {
        return view('grammars.show', compact('grammar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grammar $grammar)
    {
        return view('grammars.edit', compact('grammar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grammar $grammar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $grammar->update($request->only('title', 'description'));

        return redirect()->route('grammars.index')->with('success', 'Grammar berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grammar $grammar)
    {
        $grammar->delete();
        return redirect()->route('grammars.index')->with('success', 'Grammar berhasil dihapus.');
    }
}
