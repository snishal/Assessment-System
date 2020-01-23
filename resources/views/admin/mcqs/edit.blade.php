@extends('admin.partials.layout')

@section('main')
    <div class="container">
        <form method="POST" action="/admin/mcqs/{{ $mcq->id }}" class="ui form">
            @csrf
            @method('PUT')
            <h1 class="ui header">Edit Question</h1>
            <div class="required field">
                <label>Question</label>
                <textarea name="text" required>{{ $mcq->text }}</textarea>
            </div>
            <div class="required five fields">
                <div class="field">
                    <label>Option 1</label>
                    <input type="text" name="option1" value="{{ $mcq->option1 }}" required>
                </div>
                <div class="field">
                    <label>Option 2</label>
                    <input type="text" name="option2" value="{{ $mcq->option2 }}" required>
                </div>
                <div class="field">
                    <label>Option 3</label>
                    <input type="text" name="option3" value="{{ $mcq->option3 }}" required>
                </div>
                <div class="field">
                    <label>Option 4</label>
                    <input type="text" name="option4" value="{{ $mcq->option4 }}" required>
                </div>
                <div class="field">
                    <label>Correct Option</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="correct_option" value="{{ $mcq->correct_option }}" required>
                        <i class="dropdown icon"></i>
                        <div class="default text">Options</div>
                        <div class="menu">
                            <div class="item" data-value="1">1</div>
                            <div class="item" data-value="2">2</div>
                            <div class="item" data-value="3">3</div>
                            <div class="item" data-value="4">4</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui input">
                <button class="ui positive button" type="submit" aria-label="Create">
                Edit
                </button>
            </div>
        </form>
    </div>
@endsection
