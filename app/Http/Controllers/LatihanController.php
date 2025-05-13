<?php

namespace App\Http\Controllers;

use App\Models\Grammar;
use Illuminate\Http\Request;

class LatihanController extends Controller
{
    public function show(Grammar $grammar)
    {
        $questions = $grammar->questions;
        $totalQuestions = $questions->count();

        if ($totalQuestions === 0) {
            return redirect()->route('grammars.show', $grammar)->with('error', 'Grammar ini belum memiliki soal.');
        }

        // reset session untuk latihan baru
        session()->put('practice.answers', []);
        return redirect()->route('latihan.question', [$grammar->id, 0]);
    }

    public function question(Grammar $grammar, $index)
    {
        $questions = $grammar->questions;
        $question = $questions[$index] ?? null;

        if (!$question) {
            return redirect()->route('latihan.result', $grammar->id);
        }

        return view('practice.show', [
            'grammar' => $grammar,
            'question' => $question,
            'currentQuestionIndex' => $index,
            'totalQuestions' => $questions->count()
        ]);
    }

    public function answer(Request $request, Grammar $grammar, $index)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $answers = session('practice.answers', []);
        $answers[$index] = $request->answer;
        session(['practice.answers' => $answers]);

        $nextIndex = $index + 1;

        return redirect()->route('latihan.question', [$grammar->id, $nextIndex]);
    }

    public function result(Grammar $grammar)
    {
        $questions = $grammar->questions;
        $userAnswers = session('practice.answers', []);
        $results = [];
        $score = 0;

        foreach ($questions as $index => $question) {
            $userAnswer = $userAnswers[$index] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;

            if ($isCorrect) $score++;

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        // clear session latihan setelah selesai
        session()->forget('practice.answers');

        return view('practice.result', compact('grammar', 'results', 'score'));
    }
}
