<x-app-layout>
    <x-slot name="header">
        {{ __('Fund Page') }}
    </x-slot>

    <div class="mt-6">
        <div class="flex justify-center">
            <div class="mr-4">
                <x-nav-link href="{{ route('fund.index') }}" :active="request()->routeIs('fund.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link href="{{ route('fund.create') }}" :active="request()->routeIs('fund.create')">
                    CREATE
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link href="{{ route('fund.edit', 1) }}" :active="request()->routeIs('fund.edit')">
                    EDIT
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link href="{{ route('fund.show', 1) }}" :active="request()->routeIs('fund.show')">
                    SHOW
                </x-nav-link>
            </div>
        </div>
    </div>

    <div class="mt-6">
        
    </div>
</x-app-layout>
