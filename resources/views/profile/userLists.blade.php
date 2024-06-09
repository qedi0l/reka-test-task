<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Списки') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include("profile.partials.lists-form")
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include("profile.partials.lists")
                </div>

        </div>
    </div>
    
<script>
    $(document).ready(function() {
        $('#listForm').on('submit', function(e) {
            e.preventDefault(); 
            let ListName = $('#ListName').val();
            let ListData = $('#ListData').val();
            $.ajax({
                url: "{{route('list.create')}}", 
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    name:ListName,
                    data:ListData,
                },
                success: function (response) {
                    $('body').html(response);
                }
            });
        });
    });
</script>

</x-app-layout>
