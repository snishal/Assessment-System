@extends('admin.partials.layout')

@section('main')
    <a class="ui right floated positive button" href="/admin/tests/create">
        Create
    </a>
    <div class="ui container three column grid cards">
        @foreach ($tests as $test)
            <div class="card">
                <div class="content">
                    <div class="ui right floated small buttons">
                        <a href="/admin/tests/{{ $test->id }}/edit" class="ui icon positive button"><i class="pencil icon"></i></a>
                        <div class="or"></div>
                        <form action="/admin/tests/{{ $test->id }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button class="ui icon negative button" type="submit" aria-label="trash">
                              <i class="trash icon"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header">{{ $test->title }}</div>
                    <div class="meta">{{ $test->duration }}</div>
                    <div class="description">
                        MCQs'
                        <ul class="ui list">
                            @foreach ($test->mcqs as $mcq)
                                <li>{{ 'Question'.$mcq->id }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="extra content">
                    <div class="inline right floated field">
                        <div class="ui toggle checkbox" data-id="{{ $test->id }}">
                            <input type="checkbox" tabindex="0" class="hidden" {{ $test->active ? 'checked' : '' }}>
                            <label>{{ $test->active ? 'Active' : 'Inactive' }}</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<script>
window.addEventListener('DOMContentLoaded', function(){
    $('.ui.checkbox')
        .api({
            action: 'toggle test status',
            method: 'POST',
            data: {
                _method: 'PUT',
                _token: '{{ csrf_token() }}',
                // active : $(this).find('input').is(':checked') ? 1 : 0,
            },
            beforeSend: function(settings){
                settings.data.active = $(this).find('input').is(':checked') ? 1 : 0;
                $(this).find('input').prop('disabled', true);
                return settings;
            },
            onSuccess: function(response){
                // console.log(response);
                $(this).find('input').prop('disabled', false);

                // console.log(($(this).find('input').is(':checked')));
                $(this).find('label').text(($(this).find('input').is(':checked') ? 'Active' : 'Inactive'));
            }
            //Failure to Handled
        })
    ;
});
</script>
