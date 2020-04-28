@extends('admin.partials.layout')

@section('content')
    <div class="ui container">
        <form method="POST" action="/admin/cqs" class="ui form">
            @csrf
            <h1 class="ui header">Create Question</h1>
            <div class="required field">
                <label>Question Name</label>
                <input type="text" name="name" placeholder="Swap Bits" required>
            </div>
            <div class="required field">
                <label>Question Description</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="field required">
                <label>Question</label>
                <div class="ui selection dropdown">
                    <input type="hidden" name="question_index" required>
                    <i class="dropdown icon"></i>
                    <div class="default text">Options</div>
                    <div class="menu">
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

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function(){
    chapterWiseProblems = {!!$problems!!};

    console.log(chapterWiseProblems)

    let selectors = new Array()
    for(i = 0; i < chapterWiseProblems.length; i++){
        for(j = 0; j < chapterWiseProblems[i].problems.length; j++){
            selectors.push({
                name: chapterWiseProblems[i].problems[j].name,
                value: i + "," + j
            })
        }
    }
    $('.ui.dropdown')
        .dropdown({
            values: selectors
        })
    ;
});
</script>
@endsection
