<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultipleChoiceQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiple_choice_question_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_response_id');
            $table->unsignedBigInteger('mcq_id');
            $table->set('response_option', [1, 2, 3, 4]);
            $table->timestamps();

            $table->foreign('test_response_id')
                    ->references('id')->on('test_responses')
                    ->onDelete('cascade');

            $table->foreign('mcq_id')
                    ->references('id')->on('multiple_choice_questions')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multiple_choice_question_responses');
    }
}
