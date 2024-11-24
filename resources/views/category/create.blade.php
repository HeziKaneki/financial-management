<x-category-nav-bar>
    <!-- Display Panel -->
    <div class="mt-6">
        <x-display-panel>
            <form id="categoryForm" action="{{ route('category.store') }}" method="POST" class="w-full h-full max-w-full mx-auto p-6 border rounded shadow-lg bg-white dark:bg-gray-800 dark:border-gray-600">
                @csrf
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ADD CATEGORY</h2>

                <!-- Category Name -->
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Category Name:</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Description (nullable):</label>
                    <input type="text" id="description" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <input type="submit" value="Submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </x-display-panel>
    </div>

</x-category-nav-bar>

<script>
    $(document).ready(function () {
        $('#categoryForm').on('submit', function (e) {
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
                        $('#categoryForm')[0].reset();
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