@extends('admin.partials.layout')

@section('main')
    <div class="container">
        <form method="POST" action="/admin/mcqs" class="ui form">
            @csrf
            <h1 class="ui header">Create Question</h1>
            <div class="required field">
                <label>Question</label>
                <textarea name="text" required></textarea>
            </div>
            <div class="required five fields">
                <div class="field">
                    <label>Option 1</label>
                    <input type="text" name="option1" placeholder="eg: 3.0f" required>
                </div>
                <div class="field">
                    <label>Option 2</label>
                    <input type="text" name="option2" placeholder="eg: compile error" required>
                </div>
                <div class="field">
                    <label>Option 3</label>
                    <input type="text" name="option3" placeholder="eg: a + b" required>
                </div>
                <div class="field">
                    <label>Option 4</label>
                    <input type="text" name="option4" placeholder="eg: none" required>
                </div>
                <div class="field">
                    <label>Correct Option</label>
                    <div class="ui selection dropdown">
                        <input type="hidden" name="correct_option" required>
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
                  Create
                </button>
            </div>
        </form>
    </div>
@endsection
