<form action="{{ route('funds.store') }}" method="POST" class="w-full h-full max-w-full mx-auto p-6 border rounded  bg-white dark:bg-gray-800 dark:border-gray-600">
    @csrf
    <!-- Tiêu đề -->
    <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ADD FUND</h2>

    <!-- Fund Name -->
    <div class="mb-4">
        <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Fund Name:</label>
        <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
    </div>

    <!-- Monthly -->
    <div class="mb-4">
        <label for="monthly" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Monthly:</label>
        <input type="number" id="monthly" name="monthly" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
            Submit
        </button>
    </div>
</form>
