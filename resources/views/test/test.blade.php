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
                <!-- Truyền URL động vào JavaScript -->
                <x-nav-link class="cursor-pointer" onclick="changeComponent('{{ route('fund.create') }}')">
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
    <div id="displayPanel" class="mt-6 transition-opacity duration-300 opacity-100">
    </div>

    <!-- Change Component Script -->
    <script>
        function changeComponent(compRouteUrl) {
            var content = document.getElementById('displayPanel');

            function removeContent() {
                content.classList.add('opacity-0');
                setTimeout(function () {
                    content.innerHTML = ''; 
                }, 300); 
            }

            fetch(compRouteUrl)
                .then(response => {
                    if (response.ok) {
                        return response.text(); 
                    }
                    throw new Error('Network response was not ok');
                })
                .then(html => {
                    removeContent();

                    setTimeout(function () {
                        content.innerHTML = html;
                        content.classList.remove('opacity-0');
                    }, 300);
                })
                .catch(error => {
                    console.error('Error fetching the HTML:', error);
                });
            
        }
    </script>
</x-app-layout>
