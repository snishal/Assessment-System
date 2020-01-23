@extends('admin.partials.layout')

@section('main')
    <a class="ui right floated positive button" href="/admin/mcqs/create">
        Create
    </a>
    <div class="ui container three column grid cards">
        @foreach ($mcqs as $mcq)
            <div class="card">
                <div class="content">
                    <div class="ui right floated small buttons">
                        <a href="/admin/mcqs/{{ $mcq->id }}/edit" class="ui icon positive button"><i class="pencil icon"></i></a>
                        <div class="or"></div>
                        <form action="/admin/mcqs/{{ $mcq->id }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button class="ui icon negative button" type="submit" aria-label="trash">
                            <i class="trash icon"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header">Question{{ $mcq->id }}</div>
                    <div class="description">
                        {{ $mcq->text }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
