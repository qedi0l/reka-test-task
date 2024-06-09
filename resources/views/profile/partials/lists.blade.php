<section>

    <legend>Списки</legend>
    <ul class="list-group py-6" id="lists">
        @foreach ($lists as $list)
            <li class="list-group-item" id="listID-{{$list->id}}">
                <div class="m-3 space-between">
                    <a href="{{route("list.show", ['id' => $list->id])}}" class="flex-row">
                        <p class="p-2">Список: {{$list->name}}</p>
                        @isset ($list->data)
                            <p class="p-2">Описание: {{$list->data}}</p>
                        @endisset
                    </a>
                <button type="button" onclick="deleteList({{$list->id}},'{{ csrf_token()}}')" class="btn btn-danger">Удалить</button>
                </div>
            </li>
            
        @endforeach
        <script>
            function deleteList(listID,token){
                $.ajax({
                    url: "{{route('list.delete')}}", 
                    type: 'POST',
                    data: {
                        "_token": token,
                        listID:listID,
                    },
                    success: function (response) {
                        $('body').html(response);
                    }
                });
            };
        </script>
    </ul>
</section>