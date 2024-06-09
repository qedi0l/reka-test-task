<section >
    <form id="listForm">
        @csrf
        <div class="flex flex-d-column">
            <legend>Добавить список</legend>
            <div class="mb-3">
                <x-input-label for="name" class="form-label" :value="__('Название')" />
                <x-text-input id="ListName" name="ListName" type="text" class="mt-1 block w-full" autocomplete="off" />
            </div>
            <div class="mb-3">
                <x-input-label for="data" class="form-label" :value="__('Описание')" />
                <x-text-input id="ListData" name="ListData" type="text" class="mt-1 block w-full" autocomplete="off" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button type="submit" >Save</x-primary-button>
            </div>
        </div>
    </form>

</section>