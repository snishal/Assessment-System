<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultipleChoiceQuestion extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];
}
