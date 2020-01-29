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

    public function responses(){
        return $this->belongsToMany('App\User')->using('App\TestResponse');
    }
}
