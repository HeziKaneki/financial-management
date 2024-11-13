<form action='{{ route('fund.store') }}'>
    @csrf
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="mt-4">
        <x-input-label for="monthly" :value="__('Monthly')" />
        <x-text-input id="monthly" name="monthly" type="number" class="mt-1 block w-full" required autofocus autocomplete="monthly" />
        <x-input-error class="mt-2" :messages="$errors->get('monthly')" />
    </div>
</form>