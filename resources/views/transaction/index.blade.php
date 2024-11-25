<x-transaction-nav-bar>
    

    <!-- Display Panel with Loading Indicator -->
    <div class="mt-6">
        <x-display-panel>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 border rounded dark:border-gray-600">
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">TRANSACTION INDEX</h2>

                <div class="flex justify-between">
                    <div class="w-full">
                        <form method="GET" action="{{ route('transaction.index') }}" class="flex flex-wrap gap-4">
                            <!-- Search -->
                            <input type="text" name="search" value="{{ request()->input('search') }}" 
                                class="w-1/3 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                placeholder="Search transactions...">
                            
                            <!-- From Date -->
                            <input type="date" name="from_date" value="{{ request()->input('from_date') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <input type="date" name="to_date" value="{{ request()->input('to_date') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                
                            <!-- To Date -->
                            <select name="type" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">{{ __('All Types') }}</option>
                                <option value="income" {{ request()->input('type') == 'income' ? 'selected' : '' }}>{{ __('Income') }}</option>
                                <option value="expense" {{ request()->input('type') == 'expense' ? 'selected' : '' }}>{{ __('Expense') }}</option>
                                <option value="allocate" {{ request()->input('type') == 'allocate' ? 'selected' : '' }}>{{ __('Allocate') }}</option>
                            </select>
                
                            <!-- Filter by Category -->
                            <select name="category_id" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request()->input('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                
                            <!-- Filter Button -->
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{ __('Filter') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bảng giao dịch -->
                <div class="overflow-x-auto mt-6" style="max-height: 200px;">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Transaction ID') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Date') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Amount') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Type') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Source') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Destination') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 overflow-y-auto" >
                            @foreach ($transactions as $transaction)
                                <tr id="{{ $transaction->id }}">
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->type }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->source_name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->destination_name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST" class="deleteForm inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="delete" class="text-red-500 hover:text-red-700 cursor-pointer">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="mt-4">
                    {{ $transactions->appends(['search' => $search])->links() }} <!-- Laravel sẽ tự động hiển thị phân trang -->
                </div>
            </div>
        </x-display-panel>
    </div>
    
</x-transaction-nav-bar>

<script>
    $(document).ready(function () {
        $('.deleteForm').on('submit', function (e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            formData.append('_method', 'DELETE');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            var row = $(this).closest('tr');
                var transactionId = row.attr('id');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 'success') {
                        $('#' + transactionId).remove();
                        alert(response.message);
                    } else {
                        alert(response.message)
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            })
        })
    });
</script>