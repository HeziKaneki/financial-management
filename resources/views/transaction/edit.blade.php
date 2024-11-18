<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <!-- Tiêu đề -->
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Edit Transaction</h2>

    <!-- Form chỉnh sửa giao dịch -->
    <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" class="w-full max-w-lg mx-auto p-6 border rounded-lg shadow-lg bg-white dark:bg-gray-800 dark:border-gray-600">
        @csrf
        @method('PUT')

        <!-- Source Fund (Dropdown) -->
        <div class="mb-4">
            <label for="source" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Source Fund:</label>
            <select id="source" name="source" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">-- Select Source Fund --</option>
                @foreach ($sourceFunds as $fund)
                    <option value="{{ $fund->id }}" {{ $transaction->source_id == $fund->id ? 'selected' : '' }}>{{ $fund->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label for="amount" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Amount:</label>
            <input type="number" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>

        <!-- Type (Dropdown or Text input) -->
        <div class="mb-4">
            <label for="type" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Transaction Type:</label>
            <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        <!-- Description (Optional) -->
        <div class="mb-4">
            <label for="description" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Description:</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $transaction->description) }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                {{ __('Update Transaction') }}
            </button>
        </div>
    </form>
</div>
