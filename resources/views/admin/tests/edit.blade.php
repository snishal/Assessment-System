@extends('admin.partials.layout')

@section('content')
    <div class="ui container">
        <form method="POST" action="/admin/tests/{{ $test->id }}" class="ui form">
            @method('PUT')
            @csrf
            <h1 class="ui header">Edit Test</h1>
            <div class="required field">
                <label>Title</label>
                <input type="text" name="title" value="{{ $test->title }}" required>
            </div>
            <div class="two required fields">
                <div class="field">
                    <label>MCQ Weightage</label>
                    <input type="text" name="mcqWeight" value="{{ $test->mcqWeight }}" required>
                </div>
                <div class="field">
                    <label>Coding Question Weightage</label>
                    <input type="text" name="codingWeight" value="{{ $test->codingWeight }}" required>
                </div>
            </div>
            <div class="required field">
                <label>Duration</label>
                <input type="time" name="duration" value="{{ $test->duration }}" required>
            </div>
            <div class="field remote choices">
                <label>Questions</label>
                <select multiple="" name="mcqs[]" class="ui fluid normal dropdown mcqs">
                    <option value="">Questions</option>
                </select>
            </div>
            <div class="field remote choices">
                <label>Questions</label>
                <select multiple="" name="cqs[]" class="ui fluid normal dropdown cqs">
                    <option value="">Questions</option>
                </select>
            </div>
            <button class="ui positive button" type="submit" aria-label="Create">
                Edit
            </button>
        </form>
    </div>
@endsection
@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function(){
    $('.ui.dropdown.mcqs')
        .dropdown({
            apiSettings: {
                action: 'get mcqs',
                onResponse : function(response) {
                    console.log("here")
                },
            },
        })
        .dropdown('toggle')
        @foreach ($test->mcqs->pluck('id') as $item)
        .dropdown('set selected', '{{ $item }}')
        @endforeach
    ;
    $('.ui.dropdown.cqs')
        .dropdown({
            apiSettings: {
                action: 'get cqs',
                onResponse : function(response) {
                    console.log("here")
                },
            },
        })
        .dropdown('toggle')
        @foreach ($test->cqs->pluck('id') as $item)
        .dropdown('set selected', '{{ $item }}')
        @endforeach
    ;
});
</script>
@endsection
