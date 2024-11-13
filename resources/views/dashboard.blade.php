<x-app-layout>
    <x-slot name="header">
            {{ __('Hello World!') }}
    </x-slot>

    <div class="mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Something good") }}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <x-display-panel>
            <div>
                line a
            </div>
            <br>
            <div class="mt-12">
                line b
            </div>
        </x-display-panel>
    </div>
    
    <div class="my-10">
        <x-display-panel>
            This is a line
        </x-display-panel>
    </div>
</x-app-layout>
