<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the MultipleChoiceQuestions for the Test
     */
    public function mcqs(){
        return $this->belongsToMany('App\MultipleChoiceQuestion', 'multiple_choice_question_test', 'test_id', 'mcq_id')
                    ->withTimestamps();
    }

    public function cqs(){
        return $this->belongsToMany('App\CodingQuestion', 'coding_question_test', 'test_id', 'cq_id')
                    ->withTimestamps();
    }

    public function responses(){
        return $this->belongsToMany('App\User', 'test_responses', 'test_id', 'user_id')
                    ->using('App\TestResponse')
                    ->with(['start_time', 'end_time', 'score'])
                    ->withTimestamps();
    }
}
