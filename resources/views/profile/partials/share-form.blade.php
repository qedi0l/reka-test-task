<section class="max-w-xl">
    <div class="flex flex-d-column ml-12 mt-1">
        <legend class="legeng-f">Поделится списком</legend>
        <div class="mb-3">
            <div class="flex-col">
                <x-input-label for="tags" class="form-label" :value="__('Пользователи имеющие доступ: ')" />
                <div id="tagsField" class="flex-row flex-wrap items-center p-6">
                    @php
                        $hasAccess = explode(",",$list->hasAccess);
                    @endphp
        
                    @foreach($hasAccess as $accessUser)
                        @if($accessUser)
                            <button onclick="removeSharedID({{$accessUser}})" href="#" class="pr-6">
                                <span class="badge text-bg-secondary">{{$accessUser}}</span>
                            </button> 
                        @else 
                            <span class="badge text-bg-secondary"><p>Список доступен только вам</p></span>
                        @endif
                    @endforeach
                </div>

                <form id="shareForm" class="flex-col">
                    @csrf
                    <div class="mb-3">
                        <p class="ml-3 mt-1 text-sm text-gray-600">Добавить пользователей</p>
                        <div class="flex-row">
                            <x-text-input id="sharedIDs" name="sharedIDs" type="text" class="mt-1 w-50 block w-full" placeholder="ID поьзователя" autocomplete="off" />
                            <button type="submit" class="attribute">Добавить</button>
                        </div>
                    </div>
                </form>
            
                
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#shareForm').on('submit', function(e) {
                e.preventDefault(); 
                let sharedID = $('#sharedIDs').val();
                let listID = "{{$list->id}}";
                $.ajax({
                    url: "{{route('list.share')}}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        sharedID:sharedID,
                        listID:listID,
                    },
                    success: function (response) {
                        $('body').html(response);
                    }
                });
            });
        });
        function removeSharedID(removeSharedID){
            let listID = "{{$list->id}}";
            $.ajax({
                url: "{{route('list.removeSharedID')}}", 
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    removeSharedID:removeSharedID,
                    listID:listID,
                },
                success: function (response) {
                    $('body').html(response);
                }
            });
    };
    
        
    </script>
    

</section>