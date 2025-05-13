@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">{{ $grammar->title }} - Latihan</h3>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('latihan.answer', [$grammar->id, $currentQuestionIndex]) }}" method="POST">
                @csrf

                <p><strong>Soal {{ $currentQuestionIndex + 1 }} dari {{ $totalQuestions }}</strong></p>

                <p>{{ $question->question }}</p>

                @foreach($question->options as $option)
                    <div class="form-check">
                        <input type="radio" name="answer" value="{{ $option }}" id="{{ $loop->index }}" class="form-check-input" required>
                        <label class="form-check-label" for="{{ $loop->index }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach

                <button class="btn btn-primary mt-3" type="submit">
                    {{ $currentQuestionIndex + 1 == $totalQuestions ? 'Selesai' : 'Lanjut' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
