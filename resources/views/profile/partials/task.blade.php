<section class="align-items space-between">

    <div class="flex-row">
    <input id="taskName-{{$task->id}}" class="no-border b-r-5" value="{{$task->name}}" disabled>

    @isset($tags)
        @foreach($tags as $tag)
            <p class="p-6">
                <span class="badge text-bg-secondary flex-row">{{$tag}}</span>
            </p>
        @endforeach
    @endisset

    <div class="flex-row items-center">
        <div id="tagsField" class="flex-row flex-wrap max-w-50 items-center p-6">
            @php
                $tags = explode(",",$task->tags);
            @endphp

            @foreach($tags as $tag)
                @if($tag)
                    <button onclick="deleteTag('{{$tag}}','{{$task->id}}')" href="#" class="pr-6">
                        <span class="badge text-bg-secondary">{{$tag}}</span>
                    </button> 
                @endif
            @endforeach
        </div>
        <div class="items-center">
            <form id="tagForm-{{$task->id}}" class="flex-row items-center">
                @csrf
                <x-text-input id="tagsInput-{{$task->id}}" name="tagsInput" type="text" class="mt-1 block w-full" autocomplete="off" />
                <button type="submit"  class="attribute"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg></button>
            </form>
        </div>
    </div>
</div>

<div class="flex-row pr-3">
    <div id="editTaskBtn-{{$task->id}}"><button type="button" onclick="editTask({{$task->id}})" class="btn pr-12" aria-label="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg></button></div>
    <button type="button" onclick="attachImage({{$task->id}})"  class="btn pr-12" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16"><path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/></svg></button>
    <button type="button" onclick="deleteTask()"  class="btn-close pr-6" aria-label="Delete"></button>    
</div>
</section>





<script>
    $(document).ready(function() {
        $('#tagForm-{{$task->id}}').on('submit', function(e) {
            e.preventDefault(); 
            let tagsInput = $('#tagsInput-{{$task->id}}').val();
            let taskID = "{{$task->id}}";
            $.ajax({
                url: "{{route('task.tag.set')}}", 
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    tagsInput:tagsInput,
                    taskID:taskID,
                },
                success: function (response) {
                    $('body').html(response);
                }
            });
        });
    });

    function deleteTask(){
        
        let taskID = "{{$task->id}}";
        let listID = "{{$list->id}}";
        $.ajax({
            url: "{{route('task.delete')}}", 
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                listID:listID,
                taskID:taskID,
            },
            success: function (response) {
                $('body').html(response);
            }
        });
    };

    function deleteTag(tag,taskID){
        $.ajax({
            url: "{{route('task.tag.remove')}}", 
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                tag:tag,
                taskID:taskID,
            },
            success: function (response) {
                $('body').html(response);
            }
        });
    };
    

    
</script>