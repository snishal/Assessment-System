@extends('user.partials.layout')

@section('content')
<div class="ui container three column grid cards">
    @foreach ($tests as $test)
        <div class="card">
            <div class="content">
                <div class="header">{{ $test->title }}</div>
                <div class="meta">{{ $test->duration }}</div>
                <div class="description">
                    {{ $test->cqs_count }} Coding Questions
                    <br/>
                    {{ $test->mcqs_count }} MCQs'
                    <br/>
                    Max Marks : {{ $test->mcqs_count*$test->mcqWeight + $test->cqs_count*$test->codingWeight }}
                </div>
            </div>
            <div class="extra content">
                <button class="ui right floated positive takeTest button" aria-label="Take Test" data-test-id={{ $test->id }}>
                  Take Test
                </button>
                <form id="begin-test-form-{{ $test->id }}" method="POST" action="/user/take_test/{{ $test->id }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    @endforeach
</div>

<h1 class="ui header">First header</h1>
<div class="ui container">
    <table class="ui striped table">
        <thead>
            <tr>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($testResponses as $response)
                <tr>
                    <td>{{ $response->start_time }}</td>
                    <td>{{ $response->end_time }}</td>
                    <td>{{ $response->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- Modal --}}
<div class="ui modal">
    <i class="close icon"></i>
    <div class="header">
      Message
    </div>
    <div class="content">
        <div class="description">
            <div class="ui placeholder">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
    </div>
    <div class="actions">
      <div class="ui black deny button">
        Nope
      </div>
      <div class="ui positive right labeled icon beginTest button">
        Yes
        <i class="checkmark icon"></i>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function(){
    $('.ui.modal')
        .modal({
            blurring: true,
            onApprove: function($element) {
                document.getElementById('begin-test-form-' + $element.data('testId')).submit();
            },
        })
        .modal('setting', 'closable', false)
        .modal('setting', 'transition', 'vertical flip')
    ;

    $('.takeTest.button').on('click', function(event){
        $('.ui.modal')
            .modal('show')
        ;
        $('.ui.modal').find('.beginTest.button').data('testId', $(this).data('testId'));
    });

});
</script>
@endsection
