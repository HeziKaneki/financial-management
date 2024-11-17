<x-app-layout>

    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="mr-4">
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('fund.index', ['get' => 'comp']) }}')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="mr-4">
                <!-- Truyền URL động vào JavaScript -->
                <x-nav-link class="cursor-pointer" :active="false" onclick="changeComponent('{{ route('fund.create') }}')">
                    CREATE
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Display Panel -->
    <div id="displayPanel" class="mt-6 transition-opacity duration-300 opacity-100">
    </div>

    <!-- Change Component Script -->
    <script>
        function changeComponent(url) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // Ẩn thẻ trước khi tải
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
                        $('#displayPanel').removeClass('opacity-0').addClass('opacity-100'); // Hiện lại thẻ khi tải xong
                    }, 300); // Đợi hiệu ứng CSS hoàn tất
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }
    </script>
</x-app-layout>
