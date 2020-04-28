@extends('admin.partials.layout')

@section('content')
    <div class="ui container">
        <form method="POST" action="/admin/cqs/{{ $cq->id }}" class="ui form">
            @csrf
            @method('PUT')
            <h1 class="ui header">Edit Question</h1>
            <div class="required field">
                <label>Question Name</label>
                <input type="text" name="name" value="{{ $cq->name }}" required>
            </div>
            <div class="required field">
                <label>Question</label>
                <textarea name="description" required>{{ $cq->description }}</textarea>
            </div>
            <div class="ui input">
                <button class="ui positive button" type="submit" aria-label="Create">
                Edit
                </button>
            </div>
        </form>
    </div>
@endsection
