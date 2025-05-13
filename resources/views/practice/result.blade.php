@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Hasil Latihan - {{ $grammar->title }}</h2>

    <div class="alert alert-info">
        <strong>Skor Kamu: {{ $score }}/{{ count($results) }}</strong>
    </div>

    <hr>

    @foreach($results as $index => $result)
        <div class="mb-4">
            <p><strong>Soal {{ $index + 1 }}:</strong> {{ $result['question']->question }}</p>

            <p>
                <strong>Jawaban Kamu:</strong>
                @if($result['is_correct'])
                    <span class="text-success">{{ $result['user_answer'] }} ✅</span>
                @else
                    <span class="text-danger">{{ $result['user_answer'] }} ❌</span>
                    <br>
                    <strong>Jawaban Benar:</strong> <span class="text-success">{{ $result['question']->correct_answer }}</span>
                @endif
            </p>
        </div>
        <hr>
    @endforeach

    <a href="{{ route('grammars.show', $grammar->id) }}" class="btn btn-secondary">Kembali ke Grammar</a>
@endsection
