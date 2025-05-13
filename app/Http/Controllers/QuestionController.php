<?php

namespace App\Http\Controllers;

use App\Models\Grammar;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Grammar $grammar)
    {
        $questions = $grammar->questions()->latest()->get();
        return view('questions.index', compact('grammar', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Grammar $grammar)
    {
        return view('questions.create', compact('grammar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Grammar $grammar)
    {
        // Memvalidasi data input yang dikirimkan dalam bentuk array
        $request->validate([
            'questions.*.type' => 'required|in:fill_blank,meaning_choice,jp_choice',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
        ]);

        // Looping untuk menyimpan semua pertanyaan
        foreach ($request->questions as $questionData) {
            // Memproses pilihan (memisahkan dengan koma)
            $options = array_map('trim', explode(',', $questionData['options']));

            // Validasi jika jawaban benar tidak ada dalam pilihan
            if (!in_array($questionData['correct_answer'], $options)) {
                return back()->withErrors(['questions.*.correct_answer' => 'Jawaban benar harus salah satu dari pilihan yang tersedia.'])->withInput();
            }

            // Menyimpan pertanyaan ke database
            $grammar->questions()->create([
                'type' => $questionData['type'],
                'question' => $questionData['question'],
                'options' => $options,
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return redirect()->route('grammars.show', $grammar)->with('success', 'Soal berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Grammar $grammar, Question $question)
    {
        return view('questions.show', compact('grammar', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grammar $grammar, Question $question)
    {
        return view('questions.edit', compact('grammar', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grammar $grammar, Question $question)
    {
        $request->validate([
            'type' => 'required|in:fill_blank,meaning_choice,jp_choice',
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string|in:' . implode(',', $request->options),
        ]);

        $question->update([
            'type' => $request->type,
            'question' => $request->question,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('grammars.questions.index', $grammar)->with('success', 'Soal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grammar $grammar, Question $question)
    {
        $question->delete();
        return redirect()->route('grammars.show', $grammar)->with('success', 'Soal berhasil dihapus.');
    }
}
