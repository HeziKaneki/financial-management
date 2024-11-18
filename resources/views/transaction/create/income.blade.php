<x-app-layout>
    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.index')" :active="request()->routeIs('transaction.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.expense')" :active="request()->routeIs('transaction.create.expense')">
                    ADD EXPENSE
                </x-nav-link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.income')" :active="request()->routeIs('transaction.create.income')">
                    ADD INCOME
                </x-nav-link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('transaction.create.allocate')" :active="request()->routeIs('transaction.create.allocate')">
                    ALLOCATE FUND
                </x-nav-link>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <x-display-panel>
            <!-- Gọi component form-create-fund -->
            <form id="expenseForm" action="{{ route('transaction.store.income') }}" method="POST" class="w-full h-full max-w-full mx-auto p-6 border rounded shadow-lg bg-white dark:bg-gray-800 dark:border-gray-600">
                @csrf
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ADD INCOME</h2>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Amount:</label>
                    <input type="number" id="amount" name="amount" value="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <input type="submit" value="Submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                </div>
            </form>
        </x-display-panel>
    </div>

    <script>
        $(document).ready(function () {
            $('#expenseForm').on('submit', function (e) {
                e.preventDefault(); // Ngừng form submit mặc định

                var formData = new FormData(this); // Lấy dữ liệu form

                // Gửi AJAX request
                $.ajax({
                    url: $(this).attr('action'), // Lấy URL từ action của form
                    type: 'POST',
                    data: formData,
                    processData: false, // Không xử lý dữ liệu (dữ liệu dạng form)
                    contentType: false, // Không thay đổi kiểu content type
                    success: function (response) {
                        alert('success');
                        $('#expenseForm')[0].reset();
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi nếu có
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
</x-app-layout>