@extends('admin.partials.layout')

@section('content')
    <div class="ui container">
        <form method="POST" action="/admin/tests" class="ui form">
            @csrf
            <h1 class="ui header">Create Test</h1>
            <div class="required field">
                <label>Title</label>
                <input type="text" name="title" placeholder="eg: Mock Test 1" required>
            </div>
            <div class="two required fields">
                <div class="field">
                    <label>MCQ Weightage</label>
                    <input type="text" name="mcqWeight" placeholder="10" required>
                </div>
                <div class="field">
                    <label>Coding Question Weightage</label>
                    <input type="text" name="codingWeight" placeholder="100" required>
                </div>
            </div>
            <div class="required field">
                <label>Duration</label>
                <input type="time" name="duration" required>
            </div>
            <div class="field remote choices">
                <label>Questions</label>
                <select multiple="" name="mcqs[]" class="ui fluid normal dropdown">
                    <option value="">Questions</option>
                </select>
            </div>
            <button class="ui positive button" type="submit" aria-label="Create">
                Create
            </button>
        </form>
    </div>
@endsection
<script>
window.addEventListener('DOMContentLoaded', function(){
    $('.ui.dropdown')
        .dropdown({
            apiSettings: {
                action: 'get mcqs'
            },
        })
    ;
});
</script>


