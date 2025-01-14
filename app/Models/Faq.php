<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    protected $append = ['question','answer'];
    public function getQuestionAttribute()
       {
           return $this->attributes['question_' . app()->getLocale()];
       }
    public function getAnswerAttribute()
       {
           return $this->attributes['answer_' . app()->getLocale()];
       }
}
