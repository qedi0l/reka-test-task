<section class="max-w-xl">
    <form id="taskForm">
        @csrf
        <div class="flex flex-d-column">
            <legend>Добавить задачу</legend>
            <div class="mb-3">
                <x-input-label for="name" class="form-label" :value="__('Название')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="off" />
            </div>
            <div class="mb-3">
                <x-input-label for="data" class="form-label" :value="__('Задача')" />
                <textarea name="data" id="data" class="border-gray-300 width-100 light:border-gray-700 light:bg-gray-900 light:text-gray-300 focus:border-indigo-500 light:focus:border-indigo-600 focus:ring-indigo-500 light:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100"></textarea>
            </div>
            <div class="mb-3">
                <x-input-label for="tags" class="form-label" :value="__('Теги')" />
                <p class="ml-3 mt-1 text-sm text-gray-600">Перечислите теги через запятую</p>
                <x-text-input id="tags" name="tags" type="text" class="mt-1 block w-full" autocomplete="off" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>

            
        </div>
    </form>
    
    <script>
        $(document).ready(function() {
            $('#taskForm').on('submit', function(e) {
                e.preventDefault(); 
                let name = $('#name').val();
                let tags = $('#tags').val();
                let data = $('#data').val();
                let listID = "{{$list->id}}";
                $.ajax({
                    url: "{{route('task.create')}}", 
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name:name,
                        tags:tags,
                        data:data,
                        listID:listID,
                    },
                    success: function (response) {
                        $('body').html(response);
                    }
                });
            });
        });
    
        
    </script>
    

</section>