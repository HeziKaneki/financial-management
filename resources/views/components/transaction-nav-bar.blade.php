<x-app-layout>
    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="space-x-8 -my-px sm:ms-10 flex">
                <x-nav-link :href="route('transaction.index')" :active="request()->routeIs('transaction.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="space-x-8 -my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.expense')" :active="request()->routeIs('transaction.create.expense')">
                    ADD EXPENSE
                </x-nav-link>
            </div>
            <div class="space-x-8 -my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.income')" :active="request()->routeIs('transaction.create.income')">
                    ADD INCOME
                </x-nav-link>
            </div>
            <div class="space-x-8 -my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.allocate')" :active="request()->routeIs('transaction.create.allocate')">
                    ALLOCATE FUND
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Main -->
    {{ $slot }}

</x-app-layout>