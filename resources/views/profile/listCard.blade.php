<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список')}} {{"'".$list->name."'"}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex-row align-start">
                    <div class="w-50">
                        @include('profile.partials.task-form')
                    </div>
                    @php
                    @endphp
                    @if ((!str_contains(Auth::user()->id,$list->hasAccess)) or !isset($list->hasAccess))
                        <div class="w-50">
                            @include('profile.partials.share-form')
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div flex-col>
                    <legend class="mb-10">Задачи </legend>
                    <legend>Поиск по тегам</legend>
                    <form id="tagsSearch" class="d-flex pb-6" role="search">
                        <x-text-input id="tagsSearchField" name="tagsSearch" type="text" class="mt-1 block w-full" autocomplete="off" placeholder="Перечислите теги через запятую"/>
                        <x-primary-button type="submit" hidden>Save</x-primary-button>
                    </form>
                    <ul class="list-group card">
                        @foreach ($tasks as $task)
                            <li class="list-group-item">
                                @include('profile.partials.task')
                            </li>

                           
                            <form id="uploadImg-{{$task->id}}" method="post" action="{{ route('task.addImage',["taskID"=> $task->id]) }}" enctype="multipart/form-data" class="card-body pl-6 flex-column" hidden>
                                @csrf

                                @if ($task->image !="")
                                    <x-input-label for="name" class="form-label" :value="__('Изменить изображение ')" />
                                @else
                                    <x-input-label for="name" class="form-label" :value="__('Добавить изображение ')" />
                                @endif

                                <input type='file' name='file' accept='image/jpeg,image/png'>
                                <x-primary-button type="submit">Save</x-primary-button>
                            </form>


                            <div class="card-body">
                                @if ($task->image !="")
                                    <a class="img mb-3" href="{{url('storage/'.$task->image)}}"><img height="128" width="128" src="{{url('storage/'.$task->image)}}" class="rounded-xl fit-cover max-height-30 "></a>
                                @endif
                                <textarea id="taskData-{{$task->id}}" class="border-gray-300 width-100 light:border-gray-700 light:bg-gray-900 light:text-gray-300 focus:border-indigo-500 light:focus:border-indigo-600 focus:ring-indigo-500 light:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100" disabled>{{$task->data}}</textarea>
                            </div>


                            <script>
                                function editTask(taskID){
                                    let name = $('#taskName-'+taskID);
                                    let data = $('#taskData-'+taskID);
                                    let editTaskBtn = $('#editTaskBtn-'+taskID);
                                    editTaskBtn.html('<button type="button" onclick="saveChanges('+taskID+')" class="pr-24 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Save</button>');
                                    name.removeAttr('disabled');
                                    data.removeAttr('disabled');  
                                };
                                function saveChanges(taskID){
                                    let name = $('#taskName-'+taskID).val();
                                    let data = $('#taskData-'+taskID).val();
                                    $.ajax({
                                    url: "{{route('task.update')}}", 
                                    type: 'POST',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        taskID:taskID,
                                        newName:name,
                                        newData:data,
                                    },
                                    success: function (response) {
                                        $('body').html(response);
                                    }
                                });
                                };
                                function attachImage(taskID){
                                    let attachment = $('#uploadImg-'+taskID);
                                    attachment.toggle('hidden').removeAttr('hidden');
                                };
                                
                                //Search
                                $(document).ready(function() {
                                    $('#tagsSearch').on('submit', function(e) {
                                        e.preventDefault(); 
                                        let tagsSearch = $('#tagsSearchField').val();
                                        let listID = "{{$list->id}}";
                                        $.ajax({
                                            url: "{{route('task.tag.search')}}", 
                                            type: 'POST',
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                listID:listID,
                                                tagsSearch:tagsSearch,
                                            },
                                            success: function (response) {
                                                if (response.found != false)
                                                    $('body').html(response);
                                            }
                                        });
                                    });
                                });
                            </script>
                        @endforeach
                    </ul>

                </div>
            </div>



        </div>
    </div>
    
</x-app-layout>
