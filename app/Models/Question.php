<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['grammar_id', 'type', 'question', 'options', 'correct_answer'];

    protected $casts = [
        'options' => 'array',
    ];

    public function grammar()
    {
        return $this->belongsTo(Grammar::class);
    }
}
