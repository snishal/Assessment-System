@extends('admin.partials.layout')

@section('content')
    <a class="ui right floated positive button" href="/admin/cqs/create">
        Create
    </a>
    <div class="ui container three column grid cards">
        @foreach ($cqs as $cq)
            <div class="card">
                <div class="content">
                    <div class="ui right floated small buttons">
                        <a href="/admin/cqs/{{ $cq->id }}/edit" class="ui icon positive button"><i class="pencil icon"></i></a>
                        <div class="or"></div>
                        <form action="/admin/cqs/{{ $cq->id }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button class="ui icon negative button" type="submit" aria-label="trash">
                            <i class="trash icon"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header">{{ $cq->name }}</div>
                    <div class="description">
                        {{-- {{ $cq->name }} --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
