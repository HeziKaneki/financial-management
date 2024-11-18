<x-app-layout>

    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('fund.index')" :active="request()->routeIs('fund.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('fund.create')" :active="request()->routeIs('fund.create')">
                    CREATE
                </x-nav-link>
            </div>
        </div>
    </div>

</x-app-layout>