@extends('user.partials.layout')

@section('title', 'Test')

@section('content')
<div class="ui container">
    <h3 class="ui header">
        Question <span id="question_num">0</span>
    </h3>
    <div id="question" class="ui raised vertical segments" data-question-num="0">
        <div id="question_text" class="ui segment">
            QUESTION TEXT
        </div>
        <div class="ui horizontal segments">
            <div class="ui segment">
                <div id="question_option_1" class="ui radio checkbox">
                    <input type="radio" name="response">
                    <label>OPTION</label>
                </div>
            </div>
            <div class="ui segment">
                <div id="question_option_2" class="ui radio checkbox">
                    <input type="radio" name="response">
                    <label>OPTION</label>
                </div>
            </div>
        </div>
        <div class="ui horizontal segments">
            <div class="ui segment">
                <div id="question_option_3" class="ui radio checkbox">
                    <input type="radio" name="response">
                    <label>OPTION</label>
                </div>
            </div>
            <div class="ui segment">
                <div id="question_option_4" class="ui radio checkbox">
                    <input type="radio" name="response">
                    <label>OPTION</label>
                </div>
            </div>
        </div>
        <div class="ui left dividing close rail">
            <div class="ui block center aligned header">
                Question Panel
            </div>
            <div class="ui segment grid container">
                @for($i = 1; $i <= $test->loadCount('mcqs')->mcqs_count; $i++)
                    <div class="four wide column">
                        <button class="ui teal panel button" data-num={{$i - 1}}>
                            {{$i}}
                        </button>
                    </div>
                @endfor
            </div>
        </div>
        <div class="ui right dividing rail">
            <div class="ui segment container">
                <div class="ui fluid violet button">
                    Mark for Review
                </div>
                <div class="ui divider"></div>
                <div class="ui fluid negative button">
                    Finish Test
                </div>
            </div>
        </div>
    </div>
    <button id="next_btn" class="ui right floated teal button">Next</button>
    <button id="prev_btn" class="ui left floated teal button">Prev</button>
</div>
@endsection

@section('scripts')
<script>

window.addEventListener('DOMContentLoaded', function(){

    function loadQuestion(idx){
        if(idx >= 0 && idx < questions.length){
            $('#question').data('questionNum', idx);
            $('#question_num').text(idx+1);
            $('#question_text').text(questions[idx].text);
            $('#question_option_1').find('label').text(questions[idx].option1);
            $('#question_option_2').find('label').text(questions[idx].option2);
            $('#question_option_3').find('label').text(questions[idx].option3);
            $('#question_option_4').find('label').text(questions[idx].option4);
        }
    }

    function loadPrevQuestion(){
        loadQuestion($('#question').data('questionNum') - 1);
    }

    function loadNextQuestion(){
        loadQuestion($('#question').data('questionNum') + 1);
    }

    var questions = @json($test->mcqs);
    loadQuestion(0);

    $('#prev_btn').on('click', loadPrevQuestion);
    $('#next_btn').on('click', loadNextQuestion);
    $('.panel.button').on('click', function(){
        loadQuestion($(this).data('num'));
    });
});
</script>
@endsection
