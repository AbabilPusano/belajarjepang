@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="mb-2">{{ $grammar->title }}</h1>

    <p class="text-muted">{{ $grammar->description }}</p>

    <hr>

    <h4>Pertanyaan Terkait</h4>

    @if($grammar->questions->count())
        <ul class="list-group mb-4">
            @foreach($grammar->questions as $question)
                <li class="list-group-item">
                    <div>
                        <strong>({{ ucfirst(str_replace('_', ' ', $question->type)) }})</strong><br>
                        {{ $question->question }}
                    </div>

                    {{-- Form hapus --}}
                    <form action="{{ route('grammars.questions.destroy', [$grammar->id, $question->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pertanyaan">
                            🗑️ {{-- Ganti dengan ikon SVG jika ingin lebih modern --}}
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">Belum ada pertanyaan untuk grammar ini.</p>
    @endif

    {{-- Tombol tambah pertanyaan --}}
    <button class="btn btn-primary mb-3" onclick="toggleQuestionForm()">+ Tambah Pertanyaan</button>

    {{-- Form tambah pertanyaan --}}
    <div id="questionForm" style="display: none;">
        <form action="{{ route('grammars.questions.store', $grammar->id) }}" method="POST">
            @csrf

            <div id="question-list">
                @include('grammars.partials.question-form', ['index' => 0])
            </div>

            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addQuestion()">+ Tambah Pertanyaan</button>

            <button type="submit" class="btn btn-success mt-3">Simpan Pertanyaan</button>
        </form>
    </div>

    <a href="{{ route('latihan.show', $grammar->id) }}" class="btn btn-success mb-3">Latihan Sekarang</a>
</div>

{{-- Template untuk pertanyaan baru --}}
<template id="question-template">
    @include('grammars.partials.question-form', ['index' => '__INDEX__'])
</template>

<script>
    let questionCount = 1;

    function toggleQuestionForm() {
        const form = document.getElementById('questionForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function addQuestion() {
        const template = document.getElementById('question-template').innerHTML;
        const rendered = template.replace(/__INDEX__/g, questionCount);
        document.getElementById('question-list').insertAdjacentHTML('beforeend', rendered);
        questionCount++;
    }
</script>
@endsection
