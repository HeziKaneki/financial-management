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

    <!-- Display Panel with Loading Indicator -->
    <div class="mt-6">
            <x-display-panel>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 border rounded dark:border-gray-600">
                    <!-- Tiêu đề -->
                    <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">TRANSACTION INDEX</h2>

                    <!-- Thanh tìm kiếm -->
                    <div class="mt-6 flex justify-between">
                        <div class="w-1/2">
                            <form method="GET" action="{{ route('transaction.index') }}" class="flex">
                                <input type="text" name="search" value="{{ request()->input('search') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search transactions...">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                                    {{ __('Search') }}
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
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Source') }}</th> <!-- Thêm cột Source -->
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Destination') }}</th> <!-- Thêm cột Destination -->
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-700 overflow-y-auto" >
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->id }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">${{ number_format($transaction->amount, 2) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->type }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->source_name }}</td> <!-- Hiển thị source -->
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $transaction->destination_name }}</td> <!-- Hiển thị destination -->
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                            <a href="{{ route('transaction.show', $transaction->id) }}" class="text-blue-500 hover:text-blue-700 mr-4">{{ __('View') }}</a>
                                            <a href="{{ route('transaction.edit', $transaction->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-4">{{ __('Edit') }}</a>
                                            <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">{{ __('Delete') }}</button>
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
</x-app-layout>