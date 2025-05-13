<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('grammars', GrammarController::class);
Route::resource('grammars.questions', QuestionController::class);

Route::get('/latihan/{grammar}', [LatihanController::class, 'show'])->name('latihan.show');
Route::get('/latihan/{grammar}/soal/{index}', [LatihanController::class, 'question'])->name('latihan.question');
Route::post('/latihan/{grammar}/{index}', [LatihanController::class, 'answer'])->name('latihan.answer');
Route::get('/latihan/{grammar}/hasil', [LatihanController::class, 'result'])->name('latihan.result');

