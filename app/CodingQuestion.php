<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodingQuestion extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    public function tests(){
        return $this->belongsToMany('App\Test', 'coding_question_test', 'test_id', 'cq_id')
                    ->withTimestamps();
    }
}
