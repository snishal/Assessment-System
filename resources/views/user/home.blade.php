@extends('user.partials.layout')

@section('main')
<div class="ui container three column grid cards">
    @foreach ($tests as $test)
        <div class="card">
            <div class="content">
                <div class="header">{{ $test->title }}</div>
                <div class="meta">{{ $test->duration }}</div>
                <div class="description">
                    {{ $test->mcqs_count }} MCQs'
                    <br/>
                    Max Marks : {{ $test->mcqs_count*$test->mcqWeight }}
                </div>
            </div>
            <div class="extra content">
                <button class="ui right floated positive takeTest button" aria-label="Take Test">
                  Take Test
                </button>
            </div>
        </div>
    @endforeach
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
      <div class="ui positive right labeled icon button">
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
            onApprove : function() {
                window.alert('Approved!');
            }
        })
        .modal('setting', 'closable', false)
        .modal('setting', 'transition', 'vertical flip')
        .modal('attach events', '.takeTest.button', 'show')
    ;
});
</script>
@endsection
