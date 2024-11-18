<x-app-layout>
    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('transaction.index') }}')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('transaction.expense.create') }}')">
                    ADD EXPENSE
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('transaction.income.create') }}')">
                    ADD INCOME
                </x-nav-link>
            </div>
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('transaction.allocate.create') }}')">
                    ALLOCATE FUND
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Display Panel with Loading Indicator -->
    <div id="displayPanel" class="mt-6 transition-opacity duration-300 opacity-100">
        <div id="loadingIndicator" class="hidden text-center dark:text-white">
            Loading...
        </div>
    </div>

    <!-- Change Component Script -->
    <script>
        function changeComponent(url) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // Hiển thị thông báo loading
            $('#loadingIndicator').removeClass('hidden');
            $('#displayPanel').removeClass('opacity-100').addClass('opacity-0');

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (response) {
                    setTimeout(() => {
                        $('#displayPanel').html(response);
                        $('#loadingIndicator').addClass('hidden');
                        $('#displayPanel').removeClass('opacity-0').addClass('opacity-100');
                    }, 300); // Đợi hiệu ứng CSS hoàn tất
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                    $('#loadingIndicator').addClass('hidden');
                }
            });
        }
    </script>
</x-app-layout>
