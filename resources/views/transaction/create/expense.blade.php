<x-transaction-nav-bar>

    <div class="mt-6">
        <x-display-panel>
            <!-- Gọi component form-create-fund -->
            <form id="expenseForm" action="{{ route('transaction.store.expense') }}" method="POST" class="w-full h-full max-w-full mx-auto p-6 border rounded shadow-lg bg-white dark:bg-gray-800 dark:border-gray-600">
                @csrf
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ADD EXPENSE</h2>

                <!-- Source Fund (Dropdown) -->
                <div class="mb-4">
                    <label for="source" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Source Fund:</label>
                    <select id="source" name="source" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">-- Select Source Fund --</option>
                        @foreach ($sourceFunds as $fund)
                            <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Amount:</label>
                    <input type="number" id="amount" name="amount" value="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- categories -->
                <div class="mb-4">
                    <label for="categories" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Categories:</label>
                    <select id="categories" name="categories" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Select Categories --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Description:</label>
                    <input type="text" id="description" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#expenseForm')[0].reset();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }

                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
</x-transaction-nav-bar>
