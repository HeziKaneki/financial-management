<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        {{ __('Testing Page') }}
    </x-slot>

    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="mr-4">
                <x-nav-link class="cursor-pointer">
                    INDEX
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" onclick="changeComponent({{ route('fund.create') }})">
                    CREATE
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer">
                    EDIT
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer">
                    DELETE
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer">
                    SHOW
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Display Panel -->
    <div class="mt-6">
    </div>

    <!-- Change Component Script -->
    <script>
        function changeComponent(compRouteUrl) {
            // Delete Display Panel
                
            // GET component from server

            // Display component
        }
    </script>

</x-app-layout>