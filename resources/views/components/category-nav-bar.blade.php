<x-app-layout>
    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="space-x-8 -my-px sm:ms-10 flex">
                <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="space-x-8 -my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('category.create')" :active="request()->routeIs('category.create')">
                    CREATE
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Main -->
    {{ $slot }}

</x-app-layout>