@extends('user.partials.layout')

@section('title', 'Test')

@section('content')
<div class="ui pointing fluid two item menu">
    <div class="ui container">
        <a class="item active" data-tab="mcqs">MCQs'</a>
        <a class="item" data-tab="cqs">Coding</a>
    </div>
</div>
<div class="ui tab active" data-tab="mcqs">
    <div class="ui container">
        <h3 class="ui header">
            Question <span id="mcq_num">0</span>
        </h3>
        <div id="mcq" class="ui raised vertical segments" data-mcq-num="-1">
            <div id="mcq_text" class="ui segment large text">
                MCQ TEXT
            </div>
            <div class="ui horizontal segments">
                <div class="ui segment">
                    <div id="mcq_option_1" class="ui radio response checkbox">
                        <input type="radio" name="response" value="1">
                        <label class="bold text">OPTION</label>
                    </div>
                </div>
                <div class="ui segment">
                    <div id="mcq_option_2" class="ui radio response checkbox">
                        <input type="radio" name="response" value="2">
                        <label class="bold text">OPTION</label>
                    </div>
                </div>
            </div>
            <div class="ui horizontal segments">
                <div class="ui segment">
                    <div id="mcq_option_3" class="ui radio response checkbox">
                        <input type="radio" name="response" value="3">
                        <label class="bold text">OPTION</label>
                    </div>
                </div>
                <div class="ui segment">
                    <div id="mcq_option_4" class="ui radio response checkbox">
                        <input type="radio" name="response" value="4">
                        <label class="bold text">OPTION</label>
                    </div>
                </div>
            </div>
            <div class="ui left dividing close rail">
                <div class="ui block center aligned header">
                    Question Panel
                </div>
                <div class="ui segment grid container raised">
                    @for($i = 1; $i <= count($mcqs); $i++)
                        <div class="four wide column">
                            <button class="ui teal panel button" data-num={{$i - 1}}>
                                {{$i}}
                            </button>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="ui right dividing rail">
                <div class="ui segment container center aligned huge raised">
                    <i class="ui stopwatch large red icon"></i>
                    <span class="hour"></span>
                    :
                    <span class="min"></span>
                    :
                    <span class="sec"></span>
                </div>
                <div class="ui segment large raised container">
                    <div id="mark_for_review_btn" class="ui fluid violet button">
                        Mark for Review
                    </div>
                    <div class="ui divider"></div>
                    <div class="ui fluid negative button finish_test_btn">
                        Finish Test
                    </div>
                    <form id="finish_test_form" method="POST" action="/user/finish_test/{{ $test_response_id }}" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <button id="next_btn" class="ui right floated teal button">Next</button>
        <button id="prev_btn" class="ui left floated teal button">Prev</button>
    </div>
</div>
<div class="ui tab" data-tab="cqs">
    <div class="ui horizontal clearing segments">
        <div class="ui huge segment">
            <i class="ui stopwatch large red icon"></i>
            <span class="hour"></span>
            :
            <span class="min"></span>
            :
            <span class="sec"></span>
        </div>
        <div class="ui center aligned segment">
            @foreach ($cqs as $cq)
                <button class="ui teal button code_btn" data-index="{{ $loop->index }}">{{ $cq->name }}</button>
            @endforeach
        </div>
        <div class="ui segment">
            <div class="ui disabled loader" id="test_loader"></div>
            <div class="ui large right floated buttons">
                <button class="ui positive button" id="run_code">Run Code</button>
                <div class="or"></div>
                <button class="ui negative button finish_test_btn">Finish Test</button>
            </div>
        </div>
    </div>
    <div class="ui equal width grid">
        <div class="column">
            <div class="ui padded segment large text">
                <h3 class="ui header" id="cq_name">Question Name</h3>
                <pre id="cq_description" style="white-space: pre-wrap;">
                    Description
                </pre>
            </div>
        </div>
        <div class="column">
            <div id="cq_code" class="editor" data-index="-1">Code</div>
        </div>
    </div>
    <div class="ui padded segment large text">
        <pre id="test_result">
        </pre>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/src-min-noconflict/ace.js') }}" type="text/javascript" charset="utf-8" defer></script>
<script>
window.addEventListener('DOMContentLoaded', function(){

    $('.menu .item')
        .tab()
    ;

    var editor = ace.edit("cq_code");
    editor.session.setMode("ace/mode/c_cpp");
    editor.setFontSize(16);

    function setMarker(qno){
        prevMcq = $('#mcq').data('mcqNum');
        // active class theme
        prevMcqBtn = $(`.panel.button[data-num='${prevMcq}']`);
        currMcqBtn = $(`.panel.button[data-num='${qno}']`);

        if(!prevMcqBtn.hasClass('violet')){
            prevMcqBtn.addClass('secondary teal');
        }
        if(currMcqBtn.hasClass('violet')){
            $('#mark_for_review_btn').html('Unmark');
        }else{
            currMcqBtn.removeClass('teal');
            $('#mark_for_review_btn').html('Mark for Review');
        }
        prevMcqBtn.removeClass('secondary');
        currMcqBtn.addClass('secondary');
    }

    function loadCheckBoxes(qno){
        response = mcqResponses.find(response => response.id == mcqs[qno].mcq_id);
        if(response){
            $(`input[name=response][value='${response.responseVal}']`).prop('checked', true);
        }else{
            $('.ui.response.checkbox').checkbox('set unchecked');
        }
    }

    function loadMcq(qno){
        if(qno >= 0 && qno < mcqs.length){

            setMarker(qno);
            //header
            $('#mcq').data('mcqNum', qno);
            $('#mcq_num').text(qno+1);

            //mcq_data
            $('#mcq_text').text(mcqs[qno].text);
            $('#mcq_option_1').find('label').text(mcqs[qno].option1);
            $('#mcq_option_2').find('label').text(mcqs[qno].option2);
            $('#mcq_option_3').find('label').text(mcqs[qno].option3);
            $('#mcq_option_4').find('label').text(mcqs[qno].option4);

            loadCheckBoxes(qno);
        }
    }

    function loadCq(index){

        prevIndex = $('#mcq').data('index');
        if(prevIndex >= 0){
            cqs[prevIndex].cpp = editor.getValue();
        }
        //question_data
        $('#cq_name').text(cqs[index].name);
        $('#cq_description').text(cqs[index].description);
        editor.setValue(cqs[index].cpp);
        $('#mcq').data('index', index);
    }

    function loadPrevMcq(){
        loadMcq($('#mcq').data('mcqNum') - 1);
    }

    function loadNextMcq(){
        loadMcq($('#mcq').data('mcqNum') + 1);
    }

    function markForReview(){
        currMcq = $('#mcq').data('mcqNum');
        mcqBtn = $(`.panel.button[data-num='${currMcq}']`);
        if(mcqBtn.hasClass('violet')){
            $(this).html('Mark for Review');
        }else{
            $(this).html('Unmark');
        }
        mcqBtn.toggleClass('violet');
    }

    function finishTest(){
        $finishTestForm = $('#finish_test_form');
        $('<input>').attr({
            type: 'hidden',
            name: 'mcqResponses',
            value: JSON.stringify(mcqResponses),
        }).appendTo($finishTestForm);

        cqResponses = [];
        cqs.forEach(cq => {
            cqResponses.push({
                id: cq.cq_id,
                total: cq.total,
                passed: cq.passed
            })
        });

        $('<input>').attr({
            type: 'hidden',
            name: 'cqResponses',
            value: JSON.stringify(cqResponses),
        }).appendTo($finishTestForm);

        $('<input>').attr({
            type: 'hidden',
            name: 'test_response_id',
            value: {{ $test_response_id }},
        }).appendTo($finishTestForm);

        $finishTestForm.submit();
    }

    var mcqs = @json($mcqs);
    var cqs = @json($cqs);
    var time_left = new Date('{{$time_left}}');
    var mcqResponses = [];

    loadMcq(0);
    loadCq(0)

    $('#prev_btn').on('click', loadPrevMcq);
    $('#next_btn').on('click', loadNextMcq);
    $('.panel.button').on('click', function(){
        loadMcq($(this).data('num'));
    });
    $('#mark_for_review_btn').on('click', markForReview);

    $('.code_btn').on('click', function(){
        loadCq($(this).data('index'));
    });

    $('#run_code').on('click', function(){
        $('#run_code').prop('disabled', true);
        $('#test_loader').toggleClass('disabled active');

        $.ajax({
            method: "GET",
            url: "/user/runcode",
            data: {
                filename: cqs[$('#mcq').data('index')].cpp_filename,
                lang: "C++",
                code: editor.getValue()
            }
        })
        .done(function(response){
            $('#test_loader').toggleClass('disabled active');
            $('#run_code').prop('disabled', false);
            $('#test_result').text(response.result);

            cqs[$('#mcq').data('index')].passed = response.passed;
        });
    });

    $('.finish_test_btn').on('click', finishTest);

    $('.ui.response.checkbox')
        .checkbox({
            'onChecked': function(event){
                currMcq = $('#mcq').data('mcqNum');
                response = mcqResponses.find(response => response.id == mcqs[currMcq].mcq_id);
                if(response){
                    response.responseVal = $(this).val();
                }else{
                    mcqResponses.push({
                        'id': mcqs[currMcq].mcq_id,
                        'responseVal': $(this).val(),
                    });
                }
            }
        })
    ;

    setInterval(function(){
        if(time_left.getSeconds <= 0){
            finishTest();
        }
        $('.hour').text(time_left.getHours());
        $('.min').text(time_left.getMinutes());
        $('.sec').text(time_left.getSeconds());
        time_left.setSeconds(time_left.getSeconds() - 1);
    }, 1000);

});
</script>
@endsection
