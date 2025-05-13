@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Grammar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah --}}
    <button id= 'addGrammar' class="btn btn-primary mb-3" onclick="toggleForm()">+ Tambah Grammar</button>

    {{-- Form Tambah --}}
    <div id="createForm" style="display: none;">
        <form action="{{ route('grammars.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title">Judul Grammar</label>
                <input id='autofocus' type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <hr>
            <h5>Pertanyaan</h5>
            <div id="question-list">
                <!-- Pertanyaan awal -->
                @include('grammars.partials.question-form', ['index' => 0])
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addQuestion()">+ Tambah Pertanyaan</button>

            <hr>
            <button type="submit" class="btn btn-success mt-3">Simpan Grammar</button>
        </form>
    </div>

    {{-- List Grammar --}}
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grammars as $grammar)
            <tr>
                <td>{{ $grammar->title }}</td>
                <td>{{ Str::limit($grammar->description, 50) }}</td>
                <td></td>
                <td>
                    <form action="{{ route('grammars.destroy', [$grammar->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus grammar ini?');">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('grammars.show', $grammar) }}" class="btn btn-sm btn-info">Detail</a>
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pertanyaan">
                            🗑️ {{-- Ganti dengan ikon SVG jika ingin lebih modern --}}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Template untuk pertanyaan baru --}}
<template id="question-template">
    @include('grammars.partials.question-form', ['index' => '__INDEX__'])
</template>

<script>
    let questionCount = 1;

    function toggleForm() {
        const form = document.getElementById('createForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        const focus = document.getElementById('autofocus');
        focus.focus();
    }

    function addQuestion() {
        const template = document.getElementById('question-template').innerHTML;
        const rendered = template.replace(/__INDEX__/g, questionCount);
        document.getElementById('question-list').insertAdjacentHTML('beforeend', rendered);
        questionCount++;
    }

    document.addEventListener('keydown', function (e) {
        if (e.shiftKey && e.key === 'T') {
            e.preventDefault(); // mencegah tindakan default (opsional)
            const addBtn = document.getElementById('addGrammar');
            if (addBtn) {
                addBtn.click(); // bisa diganti aksi lain seperti toggle form
            }
        }
    });
</script>
@endsection
